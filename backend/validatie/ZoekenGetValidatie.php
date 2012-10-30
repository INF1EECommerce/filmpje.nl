<?php

class ZoekenGetValidatie {

    public function Valideer($getWaardes) {
        if (isset($getWaardes['qtext'])) {
            $result = urldecode($_GET['qtext']);
        } else {
            throw new Exception("Zoekopdracht is niet gezet.");
        }

        return $result;
    }

}

?>
