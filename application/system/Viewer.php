<?php

class Viewer {

    private $core_template = './public/html/index.php';
    public $view_list = array();

    public function addView($name, $filename, $target, $data) {
        array_push($this->view_list, array(
            'name'      => $name,
            'filename'  => $filename,
            'target'    => $target,
            'data'      => $data
        ));
    }

    public function generate() {

        // get alloy instance
        $alloy = Alloy::init();

        if ($alloy->config['view']['html_minify'] == 'react') {
            $view_file = $this->react_view();
        } else if ($alloy->config['view']['view_type'] == 'html') {
            foreach($this->view_list as $view) {
                $this->unload('./application/view/' . $view['filename'], $view['data']);
            }
        }
    }

    private function unload($file, $args) {

        // get alloy instance
        $alloy = Alloy::init();

        // Make values in the associative array easier to access by extracting them
        extract($args);

        // buffer the output (including the file is "output")
        ob_start();
        include $file;
        $html =  ob_get_clean();


        // check if minify html config is on
        if ($alloy->config['view']['html_minify']) {

            // minify html
            $html = $this->minify_html($html);
        }

        echo $html;
    }

    private function react_view() {

        // layout structure
        $layout_structure = array();

        // go through to view list
        foreach($this->view_list as $view) {

            $rjs = new ReactJS(
              // location of React's code
              file_get_contents('./public/js/generate/react-bundle.js'),

              // app code
              file_get_contents('./public/js/generate/' . $view['filename'])
            );

            // set component data
            $rjs->setComponent($view['name'], $view['data']);

            // create unquie_key for element
            $unquie_key = md5(uniqid());

            $unquie_key = $view['target'];

            // 'markup'    => '<div id="'.$unquie_key.'">' . $rjs->getMarkup() . '</div>',

            // save data
            array_push($layout_structure, array(
                'key'       => $unquie_key,
                'src'       => '/public/js/generate/' . $view['filename'],
                'markup'    => '',
                'js'        => '<script>' . $rjs->getJS("#".$unquie_key, "GLOB") . '</script>'
            ));
        }

        // create data to transfer to data
        $args = array( 'layout_data' => $layout_structure );

        // ensure the file exists
        if ( !file_exists($this->core_template) ) {
            die('Core Template File Missing');
        }

        $this->unload($this->core_template, $args);
    }

    // https://stackoverflow.com/questions/6225351/how-to-minify-php-page-html-output
    private function minify_html($body) {

        //remove redundant (white-space) characters
        $replace = array(
            //remove tabs before and after HTML tags
            '/\>[^\S ]+/s'   => '>',
            '/[^\S ]+\</s'   => '<',
            //shorten multiple whitespace sequences; keep new-line characters because they matter in JS!!!
            '/([\t ])+/s'  => ' ',
            //remove leading and trailing spaces
            '/^([\t ])+/m' => '',
            '/([\t ])+$/m' => '',
            // remove JS line comments (simple only); do NOT remove lines containing URL (e.g. 'src="http://server.com/"')!!!
            '~//[a-zA-Z0-9 ]+$~m' => '',
            //remove empty lines (sequence of line-end and white-space characters)
            '/[\r\n]+([\t ]?[\r\n]+)+/s'  => "\n",
            //remove empty lines (between HTML tags); cannot remove just any line-end characters because in inline JS they can matter!
            '/\>[\r\n\t ]+\</s'    => '><',
            //remove "empty" lines containing only JS's block end character; join with next line (e.g. "}\n}\n</script>" --> "}}</script>"
            '/}[\r\n\t ]+/s'  => '}',
            '/}[\r\n\t ]+,[\r\n\t ]+/s'  => '},',
            //remove new-line after JS's function or condition start; join with next line
            '/\)[\r\n\t ]?{[\r\n\t ]+/s'  => '){',
            '/,[\r\n\t ]?{[\r\n\t ]+/s'  => ',{',
            //remove new-line after JS's line end (only most obvious and safe cases)
            '/\),[\r\n\t ]+/s'  => '),',
            //remove quotes from HTML attributes that does not contain spaces; keep quotes around URLs!
            '~([\r\n\t ])?([a-zA-Z0-9]+)="([a-zA-Z0-9_/\\-]+)"([\r\n\t ])?~s' => '$1$2=$3$4', //$1 and $4 insert first white-space character found before/after attribute
        );
        $body = preg_replace(array_keys($replace), array_values($replace), $body);

        //remove optional ending tags (see http://www.w3.org/TR/html5/syntax.html#syntax-tag-omission )
        $remove = array(
            '</option>', '</li>', '</dt>', '</dd>', '</tr>', '</th>', '</td>'
        );
        $body = str_ireplace($remove, '', $body);

        return $body;
    }
}
