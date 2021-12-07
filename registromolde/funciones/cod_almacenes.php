<?php

 function oficiona($cod_oficina){
            switch (trim($cod_oficina)) {
                case "SMP":
                    return "00011";
                    break;
                case "SMP2":
                    return "00026";
                    break;
                case "SMP3":
                    return "00028";
                    break;
                case "SMP4":
                    return "00029";
                    break;
                case "SMP5":
                    return "00030";
                    break;
                case "SMP6":
                    return "00031";
                    break;
                case "SMP7":
                    return "00038";
                    break;
                case "SMP8":
                    return "00039";
                    break;
                case "SMP9":
                    return "00040";
                    break;
                case "SMP10":
                    return "00041";
                    break; 
            }
        }

    

?>