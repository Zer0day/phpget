<?php

# PHP-GET, a web interface for wget
# Copyright (C) 2009 Zer0day <zer0day@mail.ru>

# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.

# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.This program is free software;

# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

class parse_log{

    var $Error=false;
    var $Finished=true;
    var $File="";
    var $Process="";
    var $Speed="";
    var $Size="";
    var $Downloaded="";
    var $Url="";
    var $Start="";
    var $End="";
    var $Timeleft="";

  function parse_log($Log) {

    if(empty($Log)) { die("directory empty"); }

    $fHandle=fopen($Log, "r");
    $buffer=fread($fHandle, filesize($Log));

    preg_match("([\s][4][0][4][\s])", $buffer, $regs);
    $this->Error=$regs[0];

    preg_match_all("([0-9][0-9][0-9][0-9]\-[0-9][0-9]\-[0-3][0-9]\s[0-2][0-9]\:[0-5][0-9]\:[0-5][0-9])", $buffer, $regs);
    $this->Start=$regs[0][0];
    $this->End=$regs[0][1];	// if empty: not finished yet!

    if(empty($regs[0][1])) {
      $this->Finished=false;

      preg_match_all("([\s][0-9]*[m][0-5][0-9][s][\s])", $buffer, $regs);
      $this->Timeleft=end(end($regs));
    }

    preg_match_all("([\s][\`].*[\'][\s])", $buffer, $regs);
    $regs=trim(end(end($regs)));
    $regs=preg_replace("([\`])", "", $regs);
    $regs=preg_replace("([\'])", "", $regs);
    $regs=split('/', $regs);
    $this->File=end($regs);

    preg_match("([h][t][t][p][:][/][/].*[\n])", $buffer, $regs);
    $this->Url=trim($regs[0]);
/*
    preg_match("([\s][\(].*[s][\)][\s])", $buffer, $regs);
    $this->Speed=$regs[0];
*/
    if($this->Finished==false) {
      preg_match_all("([\%][\s].*[0-9][K,M][\s])", $buffer, $regs);
      $this->Speed=trim(preg_replace("([\%])", "", end($regs[0])));
    }

    preg_match_all("([1]?[0-9]?[0-9][%])", $buffer, $regs);
    $this->Process=end(end($regs));

    preg_match_all("([\s][0-9]*[K][\s])", $buffer, $regs);
    $regs=end(end($regs));
    $regs=trim(preg_replace("[K]", "", $regs));
    $this->Downloaded=round($regs/1024)."M";

    preg_match("([\s][0-9]*[\s][\(][0-9]*[K,M,G,T][\)][\s])", $buffer, $regs);
    $regs=preg_replace("([\s][0-9]*[\s][\(])","",$regs[0]);
    $this->Size=preg_replace("([\)])", "", $regs);
  }

}
?>
