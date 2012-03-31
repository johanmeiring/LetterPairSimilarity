<?php
/**
 * PHP implementation of Simon White's string matching algorithm, available at
 * http://www.catalysoft.com/articles/StrikeAMatch.html
 *
 * @author Johan Meiring <johan at spiraleye.com>
 * @license http://creativecommons.org/licenses/publicdomain/
 */
class LetterPairSimilarity
{
    /**
     *
     * @param string $string
     * @return array an array of adjacent letter pairs contained in the input string
     */
    private static function letterPairs($string)
    {
        $num_pairs = strlen($string) - 1;
        $pairs = array();
        for ($i = 0; $i < $num_pairs; $i++)
        {
            $pairs[] = substr($string, $i, 2);
        }
        return $pairs;
    }

    /**
     *
     * @param string $string
     * @return array an array of 2-character Strings
     */
    private static function wordLetterPairs($string)
    {
        $all_pairs = array();
        $words = explode(' ', $string);
        $word_count = count($words);
        for ($w = 0; $w < $word_count; $w++)
        {
            $pairs_in_word = self::letterPairs($words[$w]);
            $pair_count = count($pairs_in_word);
            for ($p = 0; $p < $pair_count; $p++)
            {
                $all_pairs[] = $pairs_in_word[$p];
            }
        }
        return $all_pairs;
    }

    /**
     *
     * @param string $str1
     * @param string $str2
     * @return float lexical similarity value in the range [0,1]
     */
    public static function compareStrings($str1, $str2)
    {
        $pairs1 = self::wordLetterPairs(strtoupper($str1));
        $pairs1_count = count($pairs1);
        
        $pairs2 = self::wordLetterPairs(strtoupper($str2));
        $pairs2_count = count($pairs2);
        
        $intersection = 0;
        $total_pairs = $pairs1_count + $pairs2_count;
        
        for ($i = 0; $i < $pairs1_count; $i++)
        {
            $pair1 = $pairs1[$i];
            for ($j = 0; $j < $pairs2_count; $j++)
            {                
                if (isset($pairs2[$j])) 
                {
                    $pair2 = $pairs2[$j];
                    if ($pair1 === $pair2)
                    {
                        $intersection++;
                        unset($pairs2[$j]);
                        break;
                    }
                }
            }
        }
        return (2.0 * $intersection) / $total_pairs;
    }
}