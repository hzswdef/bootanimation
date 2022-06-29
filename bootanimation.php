<?php

require __DIR__ . "/vendor/autoload.php";


class GIF
{
    # GifFrameExtractor class
    private $GFE;
    
    # path to bootanimation root folder
    private $path;
    
    # GIF data
    public $data;
    
    public function __construct(string $path, $user_settings=[]) {
        $this->path = $path;
        $this->user_settings = $user_settings;
        
        $this->GFE = new GifFrameExtractor\GifFrameExtractor();
        $this->GFE->extract($path . 'original.gif');
    }
    
    public function parse() {
        $this->parse_data();
        
        foreach ($this->GFE->getFrameImages() as $index => $frame) {
            $framename = str_pad($index, 10, '0', STR_PAD_LEFT);
            
            imagepng(
                $frame,
                $this->path . 'part0/' . $framename . '.png',
                0, # Max PNG quality
                PNG_NO_FILTER
            );
        }
    }
    
    private function parse_data() {
        $data = [];
        
        $resolution = isset($this->user_settings['resolution']) ? $this->user_settings['resolution'] : $this->GFE->getFrameDimensions()[0];
        $fps =        isset($this->user_settings['fps']) ? $this->user_settings['fps'] : 100 / $this->GFE->getFrameDurations()[0];
        
        $data = array_merge($data, $resolution);
        $data['fps'] = $fps;
        
        $this->data = $data;
    }
}


class bootanimation
{
    private string $CFG_HEAD = "%d %d %d\n";
    private string $CFG_BODY = "%s %d %d %s\n";
    
    # path to bootanimation root folder
    private string $PATH;
    
    public function __construct(string $path) {
        $this->PATH = $path;
    }
    
    public function generate_config($data) {
        $cfg = "";
        
        # Configurate bootanimation config head
        $cfg .= sprintf(
            $this->CFG_HEAD,
            $data['width'],
            $data['height'],
            $data['fps']
        );
        
        # Configurate bootanimation config body
        $cfg .= sprintf(
            $this->CFG_BODY,
            'p',
            0,
            0,
            'part0'
        );
        
        $this->save_to_dir($cfg);
    }
    
    private function save_to_dir(string $cfg) {
        file_put_contents(
            $this->PATH . 'desc.txt',
            utf8_encode($cfg)
        );
    }
}


class ARCHIVE
{
    # path to bootanimation root folder
    private $path;
    
    # path to .zip
    public $archive_path;
    
    public function __construct(string $path) {
        $this->path = $path;
    }
    
        private function generate_config() {
        $_cfg = "400 360 20\np 0 0 part0\n";
        
        file_put_contents($this->folder . 'desc.txt', utf8_encode($cfg));
    }
    
    private function filename($path, $with_folder=false) {
        $tmp = explode('/', $path);
        
        return $with_folder ? $tmp[count($tmp) - 2] . '/' . end($tmp) : end($tmp);
    }
    
    public function archive() {
        $archive = new ZipArchive();
        $archive->open(
            $this->path . 'bootanimation.zip',
            ZipArchive::CREATE || ZipArchive::OVERWRITE
        );
        
        foreach (glob($this->path . '*') as $file) {
            if (is_dir($file)) {
                $archive->addEmptyDir($this->filename($file));
                
                foreach (glob($file . '/*') as $index=>$frame) {
                    $archive->addFile($frame, $this->filename($frame, true));
                    
                    # disable compression, DO NOT CHANGE, IMPORTANT!
                    $archive->setCompressionIndex($archive->count() - 1, ZipArchive::CM_STORE);
                }
            }
            
            if ($this->filename($file) == 'desc.txt') {
                $archive->addFile($file, 'desc.txt');
            }
            
            # disable compression, DO NOT CHANGE, IMPORTANT!
            $archive->setCompressionIndex($archive->count() - 1, ZipArchive::CM_STORE);
        }
        
        $archive->close();
        
        $this->archive_path = $this->path . 'bootanimation.zip';
    }
}


class BUILD
{
    # ZIP archive object
    private $archive;
    
    # GIF class object
    private $GIF;
    
    # bootanimation class object
    private $bootanimation;
    
    # tmp build directory path
    private $folder;
    
    public function __construct() {
        $this->preset();
        
        $this->GIF = new GIF($this->folder, []);
        $this->bootanimation = new bootanimation($this->folder);
        $this->archive = new ARCHIVE($this->folder);
        
        $this->build();
        $this->return_response();
    }
    
    private function preset() {
        if (!file_exists(__DIR__ . '/tmp')) {
            mkdir(__DIR__ . '/tmp', 0777, true);
        }
        $folder = substr(md5(mt_rand()), 0, 16);
        
        if (file_exists(__DIR__ . '/tmp/' . $folder)) {
            return $this->preset();
        }
        
        mkdir(__DIR__ . '/tmp/' . $folder);
        mkdir(__DIR__ . '/tmp/' . $folder . '/part0');
        
        $this->folder = __DIR__ . '/tmp/' . $folder . '/';
        
        move_uploaded_file($_FILES['file']['tmp_name'], $this->folder . 'original.gif');
    }
    
    private function build() {
        $this->GIF->parse();
        $this->bootanimation->generate_config(
            $this->GIF->data
        );
        $this->archive->archive();
    }
    
    private function return_response() {
        echo str_replace(__DIR__, "", $this->archive->archive_path);
        exit;
    }
}

new BUILD();

?>
