<?php
/** Relevance class */

namespace smtech\StMarksSearch;

use JsonSerializable;

/**
 * Description of a search result's relevance, with rationales
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class Relevance implements JsonSerializable
{
    const EXACT_MATCH = 5;

    /**
     * Relevance score
     *
     * Ideally in a range from 0-10, with 5 indicating a fundamentally useful
     * result.
     *
     * @var float
     */
    private $score;

    /**
     * A list of rationales indicating how the relevance score was generated.
     *
     * @var string[]
     */
    private $rationales = [];

    /**
     * Construct a Relevance object
     *
     * @param float $score (Optional, defaults to 0.0)
     * @param string $rationale (Optional, defaults to `"Base value"` if
     *                          `$score` is non-zero`)
     */
    public function __construct($score = 0.0, $rationale = "Base value")
    {
        $this->score = $score;
        if ($score > 0) {
            $this->rationales[] = "$score: $rationale";
        }
    }

    /**
     * Add to the relevance of a score
     *
     * Or, one presumes, subtract, if `$scoreIncrement` is negative!
     *
     * @param float $scoreIncrement
     * @param string $rationale Rationale for this particular increment
     */
    public function add($scoreIncrement, $rationale)
    {
        $this->score += $scoreIncrement;
        $this->rationales[] = round($scoreIncrement, 2) . ": $rationale";
    }

    /**
     * Relevance score (ideally 0-10, with 5 indicating a fundamentally useful
     * result)
     *
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * List of rationale's for how the relevance score was calculated
     *
     * @param  string $separator (Optional, defaults to `', '`)
     * @return string List of scoring rationales
     */
    public function getRationale($separator = ', ')
    {
        return implode($separator, $this->rationales);
    }

    /**
     * Calculate what proportion of the `$haystack` is made up of `$needle`
     *
     * For example `Go Dog Go!` is 40% `Go`, `Hello World` is 100% `Hello World`
     *
     * @param string $haystack
     * @param string $needle
     * @return float
     */
    public static function stringProportion($haystack, $needle)
    {
        if (preg_match("/$needle/i", $haystack, $matches) !== 1) {
            return 0.0;
        } else {
            return self::EXACT_MATCH * strlen($needle) * count($matches) / strlen($haystack);
        }
    }

    /**
     * Return an array ready for JSON serialization
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php JsonSerializable::jsonSerialize()
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'score' => $this->getScore(),
            'rationale' => $this->getRationale()
        ];
    }
}
