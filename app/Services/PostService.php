<?php

namespace App\Services;

use App\Models\Posts;
use Carbon\Carbon;

class PostService
{
    public function getTrendingPosts($limit = 7)
    {
        return Posts::where('status', 1)
            ->select('posts.id', 'posts.title', 'posts.category_id', 'posts.description', 'posts.category_id', 'posts.thumbnail', 'posts.slug', 'posts.user_id', 'posts.views', 'posts.created_at', 'posts.updated_at')
            ->selectRaw('(posts.views + (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)) as popularity_score')
            ->leftJoin('post_views', function ($join) {
                $join->on('posts.id', '=', 'post_views.post_id')
                    ->where('post_views.viewed_at', '>=', Carbon::now()->subHours(48));
            })
            ->groupBy('posts.id', 'posts.title', 'posts.category_id', 'posts.description', 'posts.category_id', 'posts.thumbnail', 'posts.slug', 'posts.user_id', 'posts.views', 'posts.created_at', 'posts.updated_at') // Group by all selected columns
            ->orderByDesc('popularity_score')
            ->take($limit)
            ->get();
    }

    public function summarizeText($title, $text)
    {
        // Remove HTML tags and decode entities
        $text = htmlspecialchars_decode(strip_tags($text));

        // Preprocessing: split text into sentences
        $sentences = $this->splitIntoSentences($text);

        // Calculate word frequencies across all sentences
        $wordFrequency = $this->calculateWordFrequency($sentences);

        // Calculate TF-IDF scores for words
        $tfidfScores = $this->calculateTFIDF($sentences, $wordFrequency);

        // Calculate sentence scores based on various factors
        $sentenceScores = $this->scoreSentences($sentences, $wordFrequency, $tfidfScores);

        // Sort sentences by score
        arsort($sentenceScores);

        // Calculate the number of sentences for the summary (approximately 25% of the original text)
        $numSentences = count($sentences);
        $summaryLength = max(1, intval($numSentences * 0.25)); // Ensure at least one sentence is selected

        // Select the top sentences for the summary
        $summarySentences = array_slice(array_keys($sentenceScores), 0, $summaryLength, true);

        // Ensure the first sentence explains the topic
        if (!in_array($sentences[0], $summarySentences)) {
            array_unshift($summarySentences, $sentences[0]);
        }

        // Include the title as the first sentence of the summary
        array_unshift($summarySentences, $title);

        // Create the paragraph summary
        $paragraphSummary = implode('. ', $summarySentences) . '.';

        // Create the bullet-point summary
        $bulletSummary = array_map('trim', $summarySentences);

        return [
            'paragraph' => $paragraphSummary,
            'bullet_points' => $bulletSummary
        ];
    }
    private function splitIntoSentences($text)
    {
        // Split the text into sentences based on common delimiters
        $sentences = preg_split('/(?<=[.?!])\s+(?=[A-Z])/i', $text);

        // Rejoin sentences that are inside quotation marks
        $quotedSentences = [];
        $insideQuote = false;
        foreach ($sentences as $sentence) {
            if (preg_match('/"[^"]+"/', $sentence)) {
                if ($insideQuote) {
                    $quotedSentences[count($quotedSentences) - 1] .= ' ' . $sentence;
                } else {
                    $quotedSentences[] = $sentence;
                }
                $insideQuote = !$insideQuote;
            } elseif ($insideQuote) {
                $quotedSentences[count($quotedSentences) - 1] .= ' ' . $sentence;
            } else {
                $quotedSentences[] = $sentence;
            }
        }

        return $quotedSentences;
    }

    private function calculateWordFrequency($sentences)
    {
        $stopWords = ['the', 'is', 'in', 'and', 'to', 'of', 'that', 'a', 'with', 'for', 'as', 'on', 'it', 'this', 'by', 'an', 'be', 'are', 'at', 'from']; // Add more stop words as needed
        $wordFrequency = [];
        foreach ($sentences as $sentence) {
            $words = explode(' ', $sentence);
            foreach ($words as $word) {
                $word = strtolower(trim($word));
                if (!empty($word) && !in_array($word, $stopWords)) {
                    if (!isset($wordFrequency[$word])) {
                        $wordFrequency[$word] = 0;
                    }
                    $wordFrequency[$word]++;
                }
            }
        }
        return $wordFrequency;
    }

    private function calculateTFIDF($sentences, $wordFrequency)
    {
        $tfidfScores = [];
        $totalSentences = count($sentences);
        foreach ($sentences as $sentence) {
            $words = explode(' ', $sentence);
            foreach ($words as $word) {
                $word = strtolower(trim($word));
                if (!empty($word) && isset($wordFrequency[$word])) {
                    $tf = $wordFrequency[$word] / count($words); // Term frequency
                    $idf = log($totalSentences / $wordFrequency[$word]); // Inverse document frequency
                    if (!isset($tfidfScores[$word])) {
                        $tfidfScores[$word] = 0;
                    }
                    $tfidfScores[$word] += $tf * $idf; // TF-IDF score
                }
            }
        }
        return $tfidfScores;
    }
    private function scoreSentences($sentences, $wordFrequency, $tfidfScores)
    {
        $sentenceScores = [];
        $totalSentences = count($sentences);
        foreach ($sentences as $index => $sentence) {
            $sentenceScores[$sentence] = 0;
            $words = explode(' ', $sentence);
            $sentenceLength = count($words);
            foreach ($words as $word) {
                $word = strtolower(trim($word));
                if (isset($wordFrequency[$word]) && isset($tfidfScores[$word])) {
                    // Weighted sum of word frequency and TF-IDF score
                    $sentenceScores[$sentence] += $wordFrequency[$word] + $tfidfScores[$word];
                }
            }
            // Penalize sentence length
            $sentenceScores[$sentence] -= abs(20 - $sentenceLength);
            // Additional scoring based on position and keywords
            $positionScore = 1 - abs($index - $totalSentences / 2) / ($totalSentences / 2);
            $sentenceScores[$sentence] += $positionScore;
            // Example keyword boost
            if (stripos($sentence, 'important') !== false) {
                $sentenceScores[$sentence] += 2;
            }
        }

        // Sort sentences by score, keeping keys
        arsort($sentenceScores);

        // If the last sentence of the original text is included, ensure it is the last sentence of the summary
        if (isset($sentenceScores[end($sentences)])) {
            $lastSentence = end($sentences);
            unset($sentenceScores[$lastSentence]);
            $sentenceScores[$lastSentence] = 0; // Reset score to ensure it is placed at the end
        }

        return $sentenceScores;
    }
}
