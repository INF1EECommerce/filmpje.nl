<?php
class ArrayGrouper
{
    public static function GroupArray($array, $key)
    {
        $groupedArray = array();

        foreach ($array as $item) {
            $keyItem = $item[$key];
             if (!isset($groupedArray[$keyItem])) {
                $groupedArray[$keyItem] = array(
                    'items' => array($item),
                    'count' => 1,
                    'KeyItem' => $item[$key]
                );
            } else {
                $groupedArray[$keyItem]['items'][] = $item;
                $groupedArray[$keyItem]['count'] += 1;
            }
        }
        
        return $groupedArray;
    }
}

?>
