<?php

namespace AdventOfCode\Days;

use AdventOfCode\Common\Solver;

class Day07 extends Solver
{
    const CARD_PRIORITY = ['A', 'K', 'Q', 'J', 'T', 9, 8, 7, 6, 5, 4, 3, 2];
    const CARD_PRIORITY_WITH_WILD = ['A', 'K', 'Q', 'T', 9, 8, 7, 6, 5, 4, 3, 2, 'J'];
    private const TYPE_PRIORITY = ['5K', '4K', 'FH', '3K', '2P', '1P', 'HC'];

    public function solve()
    {
        $hands = array_map(function($row) {
            $cards = str_split(explode(' ', $row)[0]);
            return [
                'cards' => $cards,
                'bid' => explode(' ', $row)[1],
                'type1' => $this->getType($cards),
                'type2' => $this->getBestTypeWithWild($cards)
            ];
        }, explode(PHP_EOL, $this->input));

        $this->orderByStrength($hands, 'type1', self::CARD_PRIORITY);
        $this->part1 = $this->getWinnings($hands);

        $this->orderByStrength($hands, 'type2', self::CARD_PRIORITY_WITH_WILD);
        $this->part2 = $this->getWinnings($hands);
    }

    private function getType(array $cards): string
    {
        $differentCards = array_count_values($cards);
        arsort($differentCards);
        return match (count($differentCards)) {
            1 => '5K',
            2 => reset($differentCards) === 4 ? '4K' : 'FH',
            3 => reset($differentCards) === 3 ? '3K' : '2P',
            4 => '1P',
            default => 'HC',
        };
    }

    private function getBestTypeWithWild(array $cards): string
    {
        if (array_search('J', $cards) === -1) {
            return $this->getType($cards);
        }
        $allPossibleTypes = [];
        foreach (array_intersect(self::CARD_PRIORITY_WITH_WILD, $cards) as $replacement) {
            $currentCards = array_map(function ($card) use ($replacement) {
                return $card === 'J' ? $replacement : $card;
            }, $cards);
            $type = $this->getType($currentCards);
            $allPossibleTypes[array_search($type, self::TYPE_PRIORITY)] = $type;
        }
        ksort($allPossibleTypes);
        return array_shift($allPossibleTypes);
    }

    private function orderByStrength(array &$hands, string $typeMarker, array $cardPriority)
    {
        usort($hands, function($a, $b) use ($typeMarker, $cardPriority) {
            $aTypeRank = array_search($a[$typeMarker], self::TYPE_PRIORITY);
            $bTypeTank = array_search($b[$typeMarker], self::TYPE_PRIORITY);
            if ($aTypeRank === $bTypeTank) {
                foreach (range(0, 4) as $index) {
                    $aCardRank = array_search($a['cards'][$index], $cardPriority);
                    $bCardRank = array_search($b['cards'][$index], $cardPriority);
                    if ($aCardRank === $bCardRank) {
                        continue;
                    }
                    return $aCardRank > $bCardRank ? -1 : 1;
                }
            }

            return $aTypeRank > $bTypeTank ? -1 : 1;
        });
    }

    private function getWinnings(array $hands): int
    {
        return array_sum(array_map(function($index, $hand) {
            return ($index + 1) * $hand['bid'];
        }, array_keys($hands), $hands));
    }
}