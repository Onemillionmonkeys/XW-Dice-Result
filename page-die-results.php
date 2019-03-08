<?php
/*
* Template Name: Die results
*/
 get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<titlebar>
        <h1><?php the_title(); ?></h1>
    </titlebar>
	<column class="col-4 col-wrapper">
        <?php
            function dieconvert($r) {
                if($r >= 1 && $r <= 2) $result = 0;
                if($r >= 3 && $r <= 4) $result = 1;
                if($r >= 5 && $r <= 7) $result = 2;
                if($r == 8) $result = 3;
                
                return $result;
            }
        
            function renderconvert($rc) {
                if($rc == 0) $render = '<blank>blank</blank>';
                if($rc == 1) $render = '<focus>focus</focus>';
                if($rc == 2) $render = '<hit>hit</hit>';
                if($rc == 3) $render = '<crit>crit</crit>';
                
                return $render;
            }
        
            function rowrender($rc, $fr, $tr, $af) {
                echo '<span class="renders"><span class="renderresults">'.$rc.'</span> <span class="finalresults"><strong>'.$fr.'</strong><span>'.number_format($fr/$tr*100, 2).'%</span></span> <span class="before-after"><strong>'.$af.'</strong>'.number_format($af/$tr*100, 2).'%</span> <span class="totalresults">'.$tr.'</span></span>';   
            }
        
           
            $finalresults = array();
            for($numberofdice = 1; $numberofdice <= 6; $numberofdice++) :
                echo '<column class="col-2">';
                echo '<h3>Number of attack dices: <span class="h3-attack">'.$numberofdice.'</span></h3>';
                echo '<p class="render-p"><span class="renders"><span class="renderresults">die rolls</span> <span class="finalresults"><strong>results</strong><span>results %</span></span> <span class="before-after"><strong>results left</strong><span>results left%</span></span> <span class="totalresults">total</span></span></p>';
                unset($finalresults); $finalresults = array();
                $totalresult = pow(8,$numberofdice);
                
                for($dieroll = 1; $dieroll <= 8; $dieroll++) :
                    if($numberofdice >= 2) :
                        for($dieroll2 = 1; $dieroll2 <= 8; $dieroll2++) :
                            if($numberofdice >= 3) :
                                for($dieroll3 = 1; $dieroll3 <= 8; $dieroll3++) :
                                    if($numberofdice >= 4) :
                                        for($dieroll4 = 1; $dieroll4 <= 8; $dieroll4++) :
                                            if($numberofdice >= 5) :
                                                for($dieroll5 = 1; $dieroll5 <= 8; $dieroll5++) :
                                                    if($numberofdice >= 6 ) :
                                                        for($dieroll6 = 1; $dieroll6 <= 8; $dieroll6++) :
                                                            unset($dieresults);            
                                                            $dieresults = array(dieconvert($dieroll), dieconvert($dieroll2), dieconvert($dieroll3), dieconvert($dieroll4), dieconvert($dieroll5), dieconvert($dieroll6));
                                                            sort($dieresults);
                                                            $finalresults[$dieresults[0]][$dieresults[1]][$dieresults[2]][$dieresults[3]][$dieresults[4]][$dieresults[5]]++;    
                                                        endfor;
                                                    else : // numberofdice 6
                                                        unset($dieresults);            
                                                        $dieresults = array(dieconvert($dieroll), dieconvert($dieroll2), dieconvert($dieroll3), dieconvert($dieroll4), dieconvert($dieroll5));
                                                        sort($dieresults);
                                                        $finalresults[$dieresults[0]][$dieresults[1]][$dieresults[2]][$dieresults[3]][$dieresults[4]]++;
                                                    endif; // numberofdice 6
                                                endfor; // dieroll 5
                                            else : // numberofdice 5
                                                unset($dieresults);            
                                                $dieresults = array(dieconvert($dieroll), dieconvert($dieroll2), dieconvert($dieroll3), dieconvert($dieroll4));
                                                sort($dieresults);
                                                $finalresults[$dieresults[0]][$dieresults[1]][$dieresults[2]][$dieresults[3]]++;        
                                            endif; // numberofdice 5
                                        endfor; //dieroll 4
                                    else : // numberofdice 4
                                        unset($dieresults);            
                                        $dieresults = array(dieconvert($dieroll), dieconvert($dieroll2), dieconvert($dieroll3));
                                        sort($dieresults);
                                        $finalresults[$dieresults[0]][$dieresults[1]][$dieresults[2]]++;
                                    endif; // numberofdice 4
                                    
                                endfor;
                            else : // numberofdice 3
        
                                unset($dieresults);            
                                $dieresults = array(dieconvert($dieroll), dieconvert($dieroll2));
                                sort($dieresults);
                                $finalresults[$dieresults[0]][$dieresults[1]]++;
                            endif; // numberofdice 3
                                
                        endfor;
                    else :  // numberofdice 2
                        unset($dieresults);
                        $dieresults = array(dieconvert($dieroll));
                        sort($dieresults);

                        $finalresults[$dieresults[0]]++;
                    endif;  // numberofdice 2    
                endfor; // $dieroll
        
               
                
                //RENDER
        
                    echo '<p class="render-p">';
                        $before = 0;
                        $after = $totalresult;
                        $finalicons = array();
                        $finalhits = array();
                        $finalcrits = array();
                        for ($r1 = 0; $r1 <= 3; $r1++) {
                            if($r1 >= 1 ) { $icons[1] = 1; } else { $icons[1] = 0; }
                            if($r1 >= 2 ) { $hits[1] = 1; } else { $hits[1] = 0; }
                            if($r1 >= 3 ) { $crits[1] = 1; } else { $crits[1] = 0; }
                            
                            if($finalresults[$r1] > 0 && $numberofdice == 1) {
                                $rconvert = ''.renderconvert($r1).'';
                                $fresult = $finalresults[$r1];
                                
                                rowrender($rconvert, $fresult, $totalresult, $after);
                                
                                
                                $before += $finalresults[$r1];                                    
                                $after -= $finalresults[$r1];

                                $finalicons[($icons[1])] += $finalresults[$r1];
                                $finalhits[($hits[1])] += $finalresults[$r1];
                                $finalcrits[($crits[1])] += $finalresults[$r1];
                            }

                            for ($r2 = 0; $r2 <= 3; $r2++) {
                                if($r2 >= 1 ) { $icons[2] = 1; } else { $icons[2] = 0; }
                                if($r2 >= 2 ) { $hits[2] = 1; } else { $hits[2] = 0; }
                                if($r2 >= 3 ) { $crits[2] = 1; } else { $crits[2] = 0; }
                                
                                if($finalresults[$r1][$r2] > 0 && $numberofdice == 2) {
                                    $rconvert = ''.renderconvert($r1).''.renderconvert($r2).'';
                                    $fresult = $finalresults[$r1][$r2];

                                    rowrender($rconvert, $fresult, $totalresult, $after);
                                    

                                    $before += $finalresults[$r1][$r2];                                    
                                    $after -= $finalresults[$r1][$r2];
                                    
                                    $finalicons[($icons[1]+$icons[2])] += $finalresults[$r1][$r2];
                                    $finalhits[($hits[1]+$hits[2])] += $finalresults[$r1][$r2];
                                    $finalcrits[($crits[1]+$crits[2])] += $finalresults[$r1][$r2];
                                }
                                for ($r3 = 0; $r3 <= 3; $r3++) {
                                    if($r3 >= 1 ) { $icons[3] = 1; } else { $icons[3] = 0; }
                                    if($r3 >= 2 ) { $hits[3] = 1; } else { $hits[3] = 0; }
                                    if($r3 >= 3 ) { $crits[3] = 1; } else { $crits[3] = 0; }
                                    
                                    if($finalresults[$r1][$r2][$r3] > 0 && $numberofdice == 3) {
                                        $rconvert = ''.renderconvert($r1).''.renderconvert($r2).''.renderconvert($r3).'';
                                        $fresult = $finalresults[$r1][$r2][$r3];

                                        rowrender($rconvert, $fresult, $totalresult, $after);
                                        
                                        
                                        $before += $finalresults[$r1][$r2][$r3];                                    
                                        $after -= $finalresults[$r1][$r2][$r3];
                                        
                                        $finalicons[($icons[1]+$icons[2]+$icons[3])] += $finalresults[$r1][$r2][$r3];
                                        $finalhits[($hits[1]+$hits[2]+$hits[3])] += $finalresults[$r1][$r2][$r3];
                                        $finalcrits[($crits[1]+$crits[2]+$crits[3])] += $finalresults[$r1][$r2][$r3];
                                    }
                                    for ($r4 = 0; $r4 <= 3; $r4++) {
                                        if($r4 >= 1 ) { $icons[4] = 1; } else { $icons[4] = 0; }
                                        if($r4 >= 2 ) { $hits[4] = 1; } else { $hits[4] = 0; }
                                        if($r4 >= 3 ) { $crits[4] = 1; } else { $crits[4] = 0; }

                                        if($finalresults[$r1][$r2][$r3][$r4] > 0 && $numberofdice == 4) {
                                            $rconvert = ''.renderconvert($r1).''.renderconvert($r2).''.renderconvert($r3).''.renderconvert($r4).'';
                                            $fresult = $finalresults[$r1][$r2][$r3][$r4];

                                            rowrender($rconvert, $fresult, $totalresult, $after);
                                            
                                            $before += $finalresults[$r1][$r2][$r3][$r4];                                    
                                            $after -= $finalresults[$r1][$r2][$r3][$r4];

                                            $finalicons[($icons[1]+$icons[2]+$icons[3]+$icons[4])] += $finalresults[$r1][$r2][$r3][$r4];
                                            $finalhits[($hits[1]+$hits[2]+$hits[3]+$hits[4])] += $finalresults[$r1][$r2][$r3][$r4];
                                            $finalcrits[($crits[1]+$crits[2]+$crits[3]+$crits[4])] += $finalresults[$r1][$r2][$r3][$r4];
                                        }
                                        for ($r5 = 0; $r5 <= 5; $r5++) {
                                            if($r5 >= 1 ) { $icons[5] = 1; } else { $icons[5] = 0; }
                                            if($r5 >= 2 ) { $hits[5] = 1; } else { $hits[5] = 0; }
                                            if($r5 >= 3 ) { $crits[5] = 1; } else { $crits[5] = 0; }
                                            
                                            
                                            if($finalresults[$r1][$r2][$r3][$r4][$r5] > 0 && $numberofdice == 5) {
                                                $rconvert = ''.renderconvert($r1).''.renderconvert($r2).''.renderconvert($r3).''.renderconvert($r4).''.renderconvert($r5).'';
                                                $fresult = $finalresults[$r1][$r2][$r3][$r4][$r5];

                                                rowrender($rconvert, $fresult, $totalresult, $after);
                                                
                                                
                                                $before += $finalresults[$r1][$r2][$r3][$r4][$r5];
                                                $after -= $finalresults[$r1][$r2][$r3][$r4][$r5];
                                                
                                                $finalicons[($icons[1]+$icons[2]+$icons[3]+$icons[4]+$icons[5])] += $finalresults[$r1][$r2][$r3][$r4][$r5];
                                                $finalhits[($hits[1]+$hits[2]+$hits[3]+$hits[4]+$hits[5])] += $finalresults[$r1][$r2][$r3][$r4][$r5];
                                                $finalcrits[($crits[1]+$crits[2]+$crits[3]+$crits[4]+$crits[5])] += $finalresults[$r1][$r2][$r3][$r4][$r5];
                                            }
                                            for ($r6 = 0; $r6 <= 5; $r6++) {
                                                if($r6 >= 1 ) { $icons[6] = 1; } else { $icons[6] = 0; }
                                                if($r6 >= 2 ) { $hits[6] = 1; } else { $hits[6] = 0; }
                                                if($r6 >= 3 ) { $crits[6] = 1; } else { $crits[6] = 0; }
                                                
                                                if($finalresults[$r1][$r2][$r3][$r4][$r5][$r6] > 0 && $numberofdice == 6) {
                                                
                                                    $rconvert = ''.renderconvert($r1).''.renderconvert($r2).''.renderconvert($r3).''.renderconvert($r4).''.renderconvert($r5).''.renderconvert($r6).'';
                                                    $fresult = $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];

                                                    rowrender($rconvert, $fresult, $totalresult, $after);
                                                    
                                                    $before += $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];
                                                    $after -= $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];

                                                    $finalicons[($icons[1]+$icons[2]+$icons[3]+$icons[4]+$icons[5]+$icons[6])] += $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];
                                                    $finalhits[($hits[1]+$hits[2]+$hits[3]+$hits[4]+$hits[5]+$hits[6])] += $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];
                                                    $finalcrits[($crits[1]+$crits[2]+$crits[3]+$crits[4]+$crits[5]+$crits[6])] += $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];
                                                }
                                            }
                                        }
                                    }
                                }
                            }


                        }
        
                    
                    echo '</p>';
        
        
                    $after = $totalresult;
                    echo '<h3>number of icon results</h3>';
                    echo '<p class="render-p">';
                        for($x = 0; $x <= $numberofdice; $x++) {
                            $resulticon = '';
                            for($y = $numberofdice; $y > 0; $y--) {
                                if($y > $x ) {
                                    $resulticon .= '<span class="missicon"></span>';
                                } else {
                                    $resulticon .= '<span class="hiticon"></span>';
                                }
                            }
                            
                            
                            echo '<span class="renders"><span class="renderresults">'.$resulticon.'</span>  <span class="finalresults"><strong>'.$finalicons[$x].'</strong><span>'.number_format($finalicons[$x]/$totalresult*100, 2).'%</span></span> <span class="before-after"><strong> '.$after.'</strong>'.number_format($after/$totalresult*100, 2).'%</span><span class="totalresults">'.$totalresult.'</span></span>';

                            $after -= $finalicons[$x];
                        }
                    echo '</p>';
        
                    $after = $totalresult;
                    echo '<h3>number of damaging results</h3>';
                    echo '<p class="render-p">';
                        for($x = 0; $x <= $numberofdice; $x++) {
                             $resulticon = '';
                            for($y = $numberofdice; $y > 0; $y--) {
                                if($y > $x ) {
                                    $resulticon .= '<span class="missicon"></span>';
                                } else {
                                    $resulticon .= '<span class="hiticon"></span>';
                                }
                            }
                            echo '<span class="renders"><span class="renderresults">'.$resulticon.'</span>  <span class="finalresults"><strong>'.$finalhits[$x].'</strong><span>'.number_format($finalhits[$x]/$totalresult*100, 2).'%</span></span> <span class="before-after"><strong> '.$after.'</strong>'.number_format($after/$totalresult*100, 2).'%</span><span class="totalresults">'.$totalresult.'</span></span>';

                            $after -= $finalhits[$x];
                        }
                    echo '</p>';
        
                    $after = $totalresult;
                    echo '<h3>number of crit results</h3>';
                    echo '<p class="render-p">';
                        for($x = 0; $x <= $numberofdice; $x++) {
                            $resulticon = '';
                            for($y = $numberofdice; $y > 0; $y--) {
                                if($y > $x ) {
                                    $resulticon .= '<span class="missicon"></span>';
                                } else {
                                    $resulticon .= '<span class="hiticon"></span>';
                                }
                            }
                            echo '<span class="renders"><span class="renderresults">'.$resulticon.'</span>  <span class="finalresults"><strong>'.$finalcrits[$x].'</strong><span>'.number_format($finalcrits[$x]/$totalresult*100, 2).'%</span></span> <span class="before-after"><strong> '.$after.'</strong>'.number_format($after/$totalresult*100, 2).'%</span><span class="totalresults">'.$totalresult.'</span></span>';

                            $after -= $finalcrits[$x];
                        }
                    echo '</p>';
        
                    
        
                    
                echo '</column>';
            endfor; // $numberofdice
        ?>
    </column>

    <column class="col-4 col-wrapper">
        <?php
            function Edieconvert($r) {
                if($r >= 1 && $r <= 3) $result = 0;
                if($r >= 4 && $r <= 5) $result = 1;
                if($r >= 6 && $r <= 8) $result = 2;
                
                
                return $result;
            }
        
            function Erenderconvert($rc) {
                if($rc == 0) $render = '<blank>blank</blank>';
                if($rc == 1) $render = '<focus>focus</focus>';
                if($rc == 2) $render = '<evade>evade</evade>';
                
                return $render;
            }
        
            function Erowrender($rc, $fr, $tr, $af) {
                echo '<span class="renders"><span class="renderresults">'.$rc.'</span> <span class="finalresults"><strong>'.$fr.'</strong><span>'.number_format($fr/$tr*100, 2).'%</span></span> <span class="before-after"><strong>'.$af.'</strong>'.number_format($af/$tr*100, 2).'%</span> <span class="totalresults">'.$tr.'</span></span>';   
            }
        
           
            $finalresults = array();
            for($numberofdice = 1; $numberofdice <= 6; $numberofdice++) :
                echo '<column class="col-2">';
                echo '<h3>Number of defense dices: <span class="h3-evade">'.$numberofdice.'</span></h3>';
                echo '<p class="render-p"><span class="renders"><span class="renderresults">die rolls</span> <span class="finalresults"><strong>results</strong><span>results %</span></span> <span class="before-after"><strong>results left</strong><span>results left%</span></span> <span class="totalresults">total</span></span></p>';
                unset($finalresults); $finalresults = array();
                $totalresult = pow(8,$numberofdice);
                
                for($dieroll = 1; $dieroll <= 8; $dieroll++) :
                    if($numberofdice >= 2) :
                        for($dieroll2 = 1; $dieroll2 <= 8; $dieroll2++) :
                            if($numberofdice >= 3) :
                                for($dieroll3 = 1; $dieroll3 <= 8; $dieroll3++) :
                                    if($numberofdice >= 4) :
                                        for($dieroll4 = 1; $dieroll4 <= 8; $dieroll4++) :
                                            if($numberofdice >= 5) :
                                                for($dieroll5 = 1; $dieroll5 <= 8; $dieroll5++) :
                                                    if($numberofdice >= 6 ) :
                                                        for($dieroll6 = 1; $dieroll6 <= 8; $dieroll6++) :
                                                            unset($dieresults);            
                                                            $dieresults = array(Edieconvert($dieroll), Edieconvert($dieroll2), Edieconvert($dieroll3), Edieconvert($dieroll4), Edieconvert($dieroll5), Edieconvert($dieroll6));
                                                            sort($dieresults);
                                                            $finalresults[$dieresults[0]][$dieresults[1]][$dieresults[2]][$dieresults[3]][$dieresults[4]][$dieresults[5]]++;    
                                                        endfor;
                                                    else : // numberofdice 6
                                                        unset($dieresults);            
                                                        $dieresults = array(Edieconvert($dieroll), Edieconvert($dieroll2), Edieconvert($dieroll3), Edieconvert($dieroll4), Edieconvert($dieroll5));
                                                        sort($dieresults);
                                                        $finalresults[$dieresults[0]][$dieresults[1]][$dieresults[2]][$dieresults[3]][$dieresults[4]]++;
                                                    endif; // numberofdice 6
                                                endfor; // dieroll 5
                                            else : // numberofdice 5
                                                unset($dieresults);            
                                                $dieresults = array(Edieconvert($dieroll), Edieconvert($dieroll2), Edieconvert($dieroll3), Edieconvert($dieroll4));
                                                sort($dieresults);
                                                $finalresults[$dieresults[0]][$dieresults[1]][$dieresults[2]][$dieresults[3]]++;        
                                            endif; // numberofdice 5
                                        endfor; //dieroll 4
                                    else : // numberofdice 4
                                        unset($dieresults);            
                                        $dieresults = array(Edieconvert($dieroll), Edieconvert($dieroll2), Edieconvert($dieroll3));
                                        sort($dieresults);
                                        $finalresults[$dieresults[0]][$dieresults[1]][$dieresults[2]]++;
                                    endif; // numberofdice 4
                                    
                                endfor;
                            else : // numberofdice 3
        
                                unset($dieresults);            
                                $dieresults = array(Edieconvert($dieroll), Edieconvert($dieroll2));
                                sort($dieresults);
                                $finalresults[$dieresults[0]][$dieresults[1]]++;
                            endif; // numberofdice 3
                                
                        endfor;
                    else :  // numberofdice 2
                        unset($dieresults);
                        $dieresults = array(Edieconvert($dieroll));
                        sort($dieresults);

                        $finalresults[$dieresults[0]]++;
                    endif;  // numberofdice 2    
                endfor; // $dieroll
        
               
                
                //RENDER
        
                    echo '<p class="render-p">';
                        $before = 0;
                        $after = $totalresult;
                        $finalicons = array();
                        $finalhits = array();
                        $finalcrits = array();
                        for ($r1 = 0; $r1 <= 3; $r1++) {
                            if($r1 >= 1 ) { $icons[1] = 1; } else { $icons[1] = 0; }
                            if($r1 >= 2 ) { $hits[1] = 1; } else { $hits[1] = 0; }
                            if($r1 >= 3 ) { $crits[1] = 1; } else { $crits[1] = 0; }
                            
                            if($finalresults[$r1] > 0 && $numberofdice == 1) {
                                $rconvert = ''.Erenderconvert($r1).'';
                                $fresult = $finalresults[$r1];
                                
                                rowrender($rconvert, $fresult, $totalresult, $after);
                                
                                
                                $before += $finalresults[$r1];                                    
                                $after -= $finalresults[$r1];

                                $finalicons[($icons[1])] += $finalresults[$r1];
                                $finalhits[($hits[1])] += $finalresults[$r1];
                                $finalcrits[($crits[1])] += $finalresults[$r1];
                            }

                            for ($r2 = 0; $r2 <= 3; $r2++) {
                                if($r2 >= 1 ) { $icons[2] = 1; } else { $icons[2] = 0; }
                                if($r2 >= 2 ) { $hits[2] = 1; } else { $hits[2] = 0; }
                                if($r2 >= 3 ) { $crits[2] = 1; } else { $crits[2] = 0; }
                                
                                if($finalresults[$r1][$r2] > 0 && $numberofdice == 2) {
                                    $rconvert = ''.Erenderconvert($r1).''.Erenderconvert($r2).'';
                                    $fresult = $finalresults[$r1][$r2];

                                    rowrender($rconvert, $fresult, $totalresult, $after);
                                    

                                    $before += $finalresults[$r1][$r2];                                    
                                    $after -= $finalresults[$r1][$r2];
                                    
                                    $finalicons[($icons[1]+$icons[2])] += $finalresults[$r1][$r2];
                                    $finalhits[($hits[1]+$hits[2])] += $finalresults[$r1][$r2];
                                    $finalcrits[($crits[1]+$crits[2])] += $finalresults[$r1][$r2];
                                }
                                for ($r3 = 0; $r3 <= 3; $r3++) {
                                    if($r3 >= 1 ) { $icons[3] = 1; } else { $icons[3] = 0; }
                                    if($r3 >= 2 ) { $hits[3] = 1; } else { $hits[3] = 0; }
                                    if($r3 >= 3 ) { $crits[3] = 1; } else { $crits[3] = 0; }
                                    
                                    if($finalresults[$r1][$r2][$r3] > 0 && $numberofdice == 3) {
                                        $rconvert = ''.Erenderconvert($r1).''.Erenderconvert($r2).''.Erenderconvert($r3).'';
                                        $fresult = $finalresults[$r1][$r2][$r3];

                                        rowrender($rconvert, $fresult, $totalresult, $after);
                                        
                                        
                                        $before += $finalresults[$r1][$r2][$r3];                                    
                                        $after -= $finalresults[$r1][$r2][$r3];
                                        
                                        $finalicons[($icons[1]+$icons[2]+$icons[3])] += $finalresults[$r1][$r2][$r3];
                                        $finalhits[($hits[1]+$hits[2]+$hits[3])] += $finalresults[$r1][$r2][$r3];
                                        $finalcrits[($crits[1]+$crits[2]+$crits[3])] += $finalresults[$r1][$r2][$r3];
                                    }
                                    for ($r4 = 0; $r4 <= 3; $r4++) {
                                        if($r4 >= 1 ) { $icons[4] = 1; } else { $icons[4] = 0; }
                                        if($r4 >= 2 ) { $hits[4] = 1; } else { $hits[4] = 0; }
                                        if($r4 >= 3 ) { $crits[4] = 1; } else { $crits[4] = 0; }

                                        if($finalresults[$r1][$r2][$r3][$r4] > 0 && $numberofdice == 4) {
                                            $rconvert = ''.Erenderconvert($r1).''.Erenderconvert($r2).''.Erenderconvert($r3).''.Erenderconvert($r4).'';
                                            $fresult = $finalresults[$r1][$r2][$r3][$r4];

                                            rowrender($rconvert, $fresult, $totalresult, $after);
                                            
                                            $before += $finalresults[$r1][$r2][$r3][$r4];                                    
                                            $after -= $finalresults[$r1][$r2][$r3][$r4];

                                            $finalicons[($icons[1]+$icons[2]+$icons[3]+$icons[4])] += $finalresults[$r1][$r2][$r3][$r4];
                                            $finalhits[($hits[1]+$hits[2]+$hits[3]+$hits[4])] += $finalresults[$r1][$r2][$r3][$r4];
                                            $finalcrits[($crits[1]+$crits[2]+$crits[3]+$crits[4])] += $finalresults[$r1][$r2][$r3][$r4];
                                        }
                                        for ($r5 = 0; $r5 <= 5; $r5++) {
                                            if($r5 >= 1 ) { $icons[5] = 1; } else { $icons[5] = 0; }
                                            if($r5 >= 2 ) { $hits[5] = 1; } else { $hits[5] = 0; }
                                            if($r5 >= 3 ) { $crits[5] = 1; } else { $crits[5] = 0; }
                                            
                                            
                                            if($finalresults[$r1][$r2][$r3][$r4][$r5] > 0 && $numberofdice == 5) {
                                                $rconvert = ''.Erenderconvert($r1).''.Erenderconvert($r2).''.Erenderconvert($r3).''.Erenderconvert($r4).''.Erenderconvert($r5).'';
                                                $fresult = $finalresults[$r1][$r2][$r3][$r4][$r5];

                                                rowrender($rconvert, $fresult, $totalresult, $after);
                                                
                                                
                                                $before += $finalresults[$r1][$r2][$r3][$r4][$r5];
                                                $after -= $finalresults[$r1][$r2][$r3][$r4][$r5];
                                                
                                                $finalicons[($icons[1]+$icons[2]+$icons[3]+$icons[4]+$icons[5])] += $finalresults[$r1][$r2][$r3][$r4][$r5];
                                                $finalhits[($hits[1]+$hits[2]+$hits[3]+$hits[4]+$hits[5])] += $finalresults[$r1][$r2][$r3][$r4][$r5];
                                                $finalcrits[($crits[1]+$crits[2]+$crits[3]+$crits[4]+$crits[5])] += $finalresults[$r1][$r2][$r3][$r4][$r5];
                                            }
                                            for ($r6 = 0; $r6 <= 5; $r6++) {
                                                if($r6 >= 1 ) { $icons[6] = 1; } else { $icons[6] = 0; }
                                                if($r6 >= 2 ) { $hits[6] = 1; } else { $hits[6] = 0; }
                                                if($r6 >= 3 ) { $crits[6] = 1; } else { $crits[6] = 0; }
                                                
                                                if($finalresults[$r1][$r2][$r3][$r4][$r5][$r6] > 0 && $numberofdice == 6) {
                                                
                                                    $rconvert = ''.Erenderconvert($r1).''.Erenderconvert($r2).''.Erenderconvert($r3).''.Erenderconvert($r4).''.Erenderconvert($r5).''.Erenderconvert($r6).'';
                                                    $fresult = $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];

                                                    rowrender($rconvert, $fresult, $totalresult, $after);
                                                    
                                                    $before += $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];
                                                    $after -= $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];

                                                    $finalicons[($icons[1]+$icons[2]+$icons[3]+$icons[4]+$icons[5]+$icons[6])] += $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];
                                                    $finalhits[($hits[1]+$hits[2]+$hits[3]+$hits[4]+$hits[5]+$hits[6])] += $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];
                                                    $finalcrits[($crits[1]+$crits[2]+$crits[3]+$crits[4]+$crits[5]+$crits[6])] += $finalresults[$r1][$r2][$r3][$r4][$r5][$r6];
                                                }
                                            }
                                        }
                                    }
                                }
                            }


                        }
        
                    
                    echo '</p>';
        
        
                    $after = $totalresult;
                    echo '<h3>number of icon results</h3>';
                    echo '<p class="render-p">';
                        for($x = 0; $x <= $numberofdice; $x++) {
                            $resulticon = '';
                            for($y = $numberofdice; $y > 0; $y--) {
                                if($y > $x ) {
                                    $resulticon .= '<span class="missicon"></span>';
                                } else {
                                    $resulticon .= '<span class="hiticon"></span>';
                                }
                            }
                            
                            
                            echo '<span class="renders"><span class="renderresults">'.$resulticon.'</span>  <span class="finalresults"><strong>'.$finalicons[$x].'</strong><span>'.number_format($finalicons[$x]/$totalresult*100, 2).'%</span></span> <span class="before-after"><strong> '.$after.'</strong>'.number_format($after/$totalresult*100, 2).'%</span><span class="totalresults">'.$totalresult.'</span></span>';

                            $after -= $finalicons[$x];
                        }
                    echo '</p>';
        
                    $after = $totalresult;
                    echo '<h3>number of evade results</h3>';
                    echo '<p class="render-p">';
                        for($x = 0; $x <= $numberofdice; $x++) {
                             $resulticon = '';
                            for($y = $numberofdice; $y > 0; $y--) {
                                if($y > $x ) {
                                    $resulticon .= '<span class="missicon"></span>';
                                } else {
                                    $resulticon .= '<span class="hiticon"></span>';
                                }
                            }
                            echo '<span class="renders"><span class="renderresults">'.$resulticon.'</span>  <span class="finalresults"><strong>'.$finalhits[$x].'</strong><span>'.number_format($finalhits[$x]/$totalresult*100, 2).'%</span></span> <span class="before-after"><strong> '.$after.'</strong>'.number_format($after/$totalresult*100, 2).'%</span><span class="totalresults">'.$totalresult.'</span></span>';

                            $after -= $finalhits[$x];
                        }
                    echo '</p>';
        
                    
        
                    
        
                    
                echo '</column>';
            endfor; // $numberofdice
        ?>
    </column>
<?php endwhile; ?>



<?php get_footer(); ?>