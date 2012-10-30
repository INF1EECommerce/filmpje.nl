<?php

class SpecialsMenuItemsView {

    var $specials;

    public function SpecialsMenuItemsView() {
        require_once 'backend/Specials.php';
        $specials = new Specials();
        $this->specials = $specials->HaalSpecialsOp(TRUE);
    }

    public function Render() {
        if (is_array($this->specials)) {

            echo ("<ul>");

            foreach ($this->specials as $special) {
                echo ("<li><a href=\"specials.php?SpecialID=" . $special['SpecialID'] . "\">" . $special['Naam'] . "</a></li>");
            }

            echo("</ul>");
        }
    }

}

?>
