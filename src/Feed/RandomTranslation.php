<?php

namespace TwitterJunkieBot\Feed;

class RandomTranslation
{
    public function getRandomTranslation($fileName)
    {
        try {
            $languageJsonFileContent = file_get_contents($fileName);
            $translationsArr = json_decode($languageJsonFileContent, true);
        } catch (\Exception $e) {
            throw new \Exception('Error getting random translation from file: ' . $fileName);
        }
        
        if (!$this->translationsDocIsWellFormed($translationsArr)) {
            throw new \Exception('Error. Language file is not found or is invalid. File: ' . $fileName);
        }

        $translations = $translationsArr['translations'];
        $numTranslations = count($translations);
        $translation = $translations[rand(0, $numTranslations - 1)];

        return $translation['source'] . ': ' . $translation['target'];
    }
    
    private function translationsDocIsWellFormed($translationsArr)
    {
        if (!isset($translationsArr['translations']) || count($translationsArr['translations']) < 1) {
            return false;
        }
        $trans = $translationsArr['translations'];

        foreach ($trans as $key => $val) {
            if (!isset($trans[$key]['source']) || !isset($trans[$key]['target'])) {
                return false;
            }
        }
        return true;
    }
}
