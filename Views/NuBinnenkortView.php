<?php

class NuBinnenkortView {

    var $dbfunctions;
    var $films;
    var $filmgroups;

    public function NuBinnenkortView() {
        include_once 'backend/DBFunctions.php';
        include_once 'Helpers/ArrayGrouper.php';
        $this->dbfunctions = new DBFunctions();
        $this->films = $this->dbfunctions->AlleFims();
        $this->filmgroups = ArrayGrouper::GroupArray($this->films, 'FilmType');
    }

    public function Render($viewModus) {
        ?>
        <div id="NuFilms"  <?php if ($viewModus == "Rows") {
            echo( "style=\"display:none;\"");
        } ?>>
            <div class="posterRow">
                <?php
                $count = 1;
                $rowcount = 1;
                foreach ($this->filmgroups['Nu']['items'] as $film) {
                    $kijwijzericonen = explode(",", $film['Kijkwijzer']);
                    $kijkwijzerhtml = "";

                    foreach ($kijwijzericonen as $icon) {
                        $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
                    }
                    ?>
                    <div id="<?php echo $film['FilmID'] ?>" class="filmoverzichtposter">
                        <p><?php echo $film['KorteNaam']; ?></p>
                        <a href="films.php?filmid=<?php echo $film['FilmID']; ?>"><img class="filoverzichtcover" src="image/Covers/<?php echo $film['Cover'] ?>"></a><br>
                        <strong>Genre</strong><br><?php echo $film['Genre']; ?>
                        <br>
                    <?php echo $kijkwijzerhtml; ?>
                    </div>    
                    <?php
                    if ($rowcount % 4 == 0 && $count != $this->filmgroups['Nu']['count']) {
                        echo '</div><div class="posterRow">';
                        $rowcount = 0;
                    }
                    if ($count == $this->filmgroups['Nu']['count']) {
                        echo '</div>';
                    }
                    $count++;
                    $rowcount++;
                }
                ?>
            </div>
            <div id="NuFilmsRows" <?php if ($viewModus == "Tiles") {
            echo( "style=\"display:none;\"");
        } ?>>
                <?php
                foreach ($this->filmgroups['Nu']['items'] as $film) {
                    $kijwijzericonen = explode(",", $film['Kijkwijzer']);
                    $kijkwijzerhtml = "";

                    foreach ($kijwijzericonen as $icon) {
                        $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
                    }
                    ?>
                    <div class="posterRow" >
                        <div id="<?php echo $film['FilmID'] ?>" class="filmoverzichtposterrowview">
                            <p><?php echo $film['KorteNaam']; ?></p>
                            <a href="films.php?filmid=<?php echo $film['FilmID']; ?>"><img class="filoverzichtcoverrowview" src="image/Covers/<?php echo $film['Cover'] ?>"></a>
                            <strong>Genre</strong><br><?php echo $film['Genre']; ?>
                            <br><br>
            <?php echo $kijkwijzerhtml; ?>
                            <br><br>
                            <div class="filmoverzichtbeschrijving"><?php echo $film['Beschrijving']; ?></div>
                        </div>
                    </div>
        <?php } ?>        
            </div>
            <div id="BinnenkortFilms" style="display:none">
                <div class="posterRow">
                    <?php
                    $count = 1;
                    $rowcount = 1;
                    foreach ($this->filmgroups['Binnenkort']['items'] as $film) {
                        $kijwijzericonen = explode(",", $film['Kijkwijzer']);
                        $kijkwijzerhtml = "";

                        foreach ($kijwijzericonen as $icon) {
                            $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
                        }
                        ?>
                        <div id="<?php echo $film['FilmID'] ?>" class="filmoverzichtposter">
                            <p><?php echo $film['KorteNaam']; ?></p>
                            <a href="films.php?filmid=<?php echo $film['FilmID']; ?>"><img class="filoverzichtcover" src="image/Covers/<?php echo $film['Cover'] ?>"></a><br>
                            <strong>Genre</strong><br><?php echo $film['Genre']; ?>
                            <br>
                        <?php echo $kijkwijzerhtml; ?>
                        </div>    
                        <?php
                        if ($rowcount % 4 == 0 && $count != $this->filmgroups['Binnenkort']['count']) {
                            echo '</div><div class="posterRow">';
                            $rowcount = 0;
                        }
                        if ($count == $this->filmgroups['Binnenkort']['count']) {
                            echo '</div>';
                        }
                        $count++;
                        $rowcount++;
                    }
                    ?>
                </div>
                <div id="BinnenkortFilmsRows" style="display:none">
                    <?php
                    foreach ($this->filmgroups['Binnenkort']['items'] as $film) {
                        $kijwijzericonen = explode(",", $film['Kijkwijzer']);
                        $kijkwijzerhtml = "";

                        foreach ($kijwijzericonen as $icon) {
                            $kijkwijzerhtml .= "<img class=\"kijkwijzer\" src=\"image/" . $icon . ".png\"/>";
                        }
                        ?>
                        <div class="posterRow">
                            <div id="<?php echo $film['FilmID'] ?>" class="filmoverzichtposterrowview">
                                <p><?php echo $film['KorteNaam']; ?></p>
                                <a href="films.php?filmid=<?php echo $film['FilmID']; ?>"><img class="filoverzichtcoverrowview" src="image/Covers/<?php echo $film['Cover'] ?>"></a>
                                <strong>Genre</strong><br><?php echo $film['Genre']; ?>
                                <br><br>
                                <?php echo $kijkwijzerhtml; ?>
                                <br><br>
                                <div class="filmoverzichtbeschrijving"><?php echo $film['Beschrijving']; ?></div>
                            </div>
                        </div>
                    <?php
                    }
                }

            }
            ?>
