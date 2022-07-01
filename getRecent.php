<?php

class recent
{
    private function get_folders() {
        $folders = [];
        $tmp = [];
        
        foreach (glob(__DIR__ . '/tmp/*') as $folder) {
            $timestamp = filemtime($folder);
            
            $folders[] = [
                'path' => str_replace(__DIR__, '', $folder),
                'timestamp' => $timestamp
            ];
            $tmp[] = $timestamp;
        }
        
        return $this->sort_folders($folders, $tmp);
    }
    
    private function sort_folders($folders, $tmp) {
        array_multisort($tmp, SORT_DESC, $folders);
        array_slice($folders, 0, 20);
        
        return $folders;
    }
    
    public function return_response() {
        $response = [];
        
        foreach ($this->get_folders() as $index => $folder) {
            $path = $folder["path"] . '/original.gif';
            
            $response[] = join("\n", [
                "<div class='recent-item'>",
                "<img src='$path' alt='bootanimation'>",
                "</div>"
            ]);
        }
        
        die(join("\n", $response));
    }
}

$recent = new recent();
$recent->return_response();

?>