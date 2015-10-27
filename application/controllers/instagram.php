<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Instagram extends CI_Controller {

    function __construct() {
        parent::__construct();
        //Include libreria para utilizacion del api de facebook
        $this->load->library('apiinstagram');
        //Include libreria de utilidad de Imagen Digital.
        $this->load->library('utilimagendigital');

        $this->load->helper('url');

        $this->load->model('profileInstagramModel');
        $this->load->model('configurationModel');
        $this->load->model('hashTagIMModel');
        $this->load->model('imtagModel');
    }

    public function index() {
        echo 'Entra index <br>';
        $loginUrl = $this->apiinstagram->getLoginUrl();
        echo "<a class=\"button\" href=\"$loginUrl\">Sign in with Instagram</a>";
        $accessToken = $this->configurationModel->getAccessTokenInstagram();
        echo '<br>' . $accessToken . '<br>';
    }

    /**
     * Index de Magnum TV IM
     */
    public function viewIm() {
        //titulo de la pagina
        $data['tittle'] = 'Magnum - Crea tu Paleta';

        $this->load->view('common/header.php', $data);
        $this->load->view('instagram.php');
        $this->load->view('common/footer.php');
    }

    public function success() {
        $code = $this->input->get('code');
        // Check whether the user has granted access
        if (true === isset($code)) {
            //Exist code verifited if exist access token
            $accessToken = $this->configurationModel->getAccessTokenInstagram();
            if (!empty($accessToken)) {
                echo 'accessToken = <br>';
                echo $accessToken . '<br>';
                echo 'Fin de Token <br>';
            } else {
                // Receive OAuth token object
                $data = $this->apiinstagram->getOAuthToken($code);
                // Take a look at the API response
                if (empty($data->user->username)) {
                    //volvemos a la pagina de autenticacion
                    redirect(base_url() . 'instagram');
                } else {
                    //almacenamos informacion.
                    $profileInstagram['username'] = $data->user->username;
                    $profileInstagram['bio'] = $data->user->bio;
                    $profileInstagram['website'] = $data->user->website;
                    $profileInstagram['profileImage'] = $data->user->profile_picture;
                    $profileInstagram['fullName'] = $data->user->full_name;
                    $profileInstagram['idInstagram'] = $data->user->id;
                    $profileInstagram['instagramAccessToken'] = $data->access_token;



                    $idProfileInstagram = $this->profileInstagramModel->addProfileInstagram($profileInstagram);
                    if ($idProfileInstagram == 0) {
                        log_message('Error', 'Class -> Instagram Method -> success ->  profileInstagram ' . implode(',', $profileInstagram));
                    }

                    $idConfiguracion = $this->configurationModel->getCurrentConfiguration();
                    if (!$this->configurationModel->updateAccessTokenInstagram($idConfiguracion, $profileInstagram['instagramAccessToken'])) {
                        log_message('Error', 'Class -> Instagram Method -> success ->  instagramAccessToken ' .
                                $profileInstagram['instagramAccessToken'] . ' idConfiguracion ' . $idConfiguracion);
                    }
                }
            }
        } else {
            // Check whether an error occurred
            if (true === isset($_GET['error'])) {
                echo 'An error occurred: ' . $_GET['error_description'];
            }
        }
    }

    public function getAllPostInstagram() {

        echo '<hr>Instagram - Inicio<br>';
        $hashTagIM = $this->config->item('INSTAGRAM_HASHTAG');
        $this->getPostInstagram($hashTagIM);
        $hashTagIM = $this->config->item('HASHTAG_PR');
        $this->getPostInstagram($hashTagIM);

        $hashList = array_merge( array(),$this->config->item('HASHTAG_LIST'));
	    $hashKeys = array_rand($hashList, 10);
	    foreach( $hashKeys as $key ) {
		    $this->getPostInstagram($hashList[$key], true );
	    }

	    echo '<br>Instagram - Fin<hr>';
    }

    public function getPostInstagram($hashTagIM, $anyUser = false ) {
        //$hashTagIM      = $this->config->item('INSTAGRAM_HASHTAG');
        echo '<br> - Tag #' . $hashTagIM . ' - Inicio<br>';
        $dataTag = $this->apiinstagram->getTagMedia($hashTagIM);

	    $this->load->model( 'trainers_model' );
	    $instagramers = array();

	    if( !$anyUser ) {
		    $instagramers = $this->trainers_model->getInstagramAccounts();

		    if( $this->config->item('INSTAGRAM_ALLOWED_USERS') )
			    $instagramers = array_merge( $instagramers, $this->config->item('INSTAGRAM_ALLOWED_USERS') );

		    $instagramers = array_map('strtolower', $instagramers);
	    }

	    if (isset($dataTag->data)) {
            echo ' - - Inicio del proceso cantidad de registros ' . count($dataTag->data) . '.<br>';
            foreach ($dataTag->data as $data) {
                if (isset($data->caption->id)) {
                    date_default_timezone_set('America/Bogota');
                    $hashTagIMArray = array();
                    $hashTagIMArray['idMessage'] = $data->caption->id;
                    $hashTagIMArray['message'] = $data->caption->text;
                    $hashTagIMArray['instagram'] = $data->user->id;
                    $hashTagIMArray['username'] = $data->user->username;
                    $hashTagIMArray['fullName'] = $data->user->full_name;
                    $hashTagIMArray['profileImage'] = $data->user->profile_picture;
                    $hashTagIMArray['image'] = $data->images->standard_resolution->url;
                    $hashTagIMArray['link'] = $data->link;
                    if ($data->type == 'video') {
                        $hashTagIMArray['videoLink'] = $data->videos->standard_resolution->url;
                    }
                    $hashTagIMArray['type'] = $data->type;
                    $hashTagIMArray['dateCreate'] = date("Y-m-d H:i:s O", $data->created_time);
                    $hashTagIMArray['fecha'] = date("Y-m-d H:i:s O", $data->created_time);
                    $hashTagIMArray['hide'] = 2;
                    if ($this->hashTagIMModel->getBlacklist($hashTagIMArray['message'])) {
                        $hashTagIMArray['hide'] = 1;
                    }                   
                    $countRep = 0;
                    $tagSchool = null;
                    $tagMaster = null;
                    foreach ($data->tags as $tag) {
                        if (strtolower($tag) == strtolower($hashTagIM)) {
                            $tagMaster = $tag;
                        } else if (strtolower($tag) != strtolower($hashTagIM) && $countRep == 0) {
                            $tagSchool = $tag;
                            $countRep = 1;
                        }
                    }
	                $idHashTagIM = 0;
                    if (
                        !empty($hashTagIMArray['idMessage'])
                        &&
                        (
	                        $anyUser
	                        ||
	                        in_array( strtolower( trim( $hashTagIMArray['username'] ) ), $instagramers )
                        )
                    ) {
                        $idHashTagIM = $this->hashTagIMModel->addHashtagIM($hashTagIMArray);
                    }

                    if ($idHashTagIM > 0) {
                        $imTag['idHashTagIM'] = $idHashTagIM;
                        $imTag['tag'] = $tagMaster;
                        $imTag['tagSchool'] = $tagSchool;
                        $idImTag = $this->imtagModel->addImTag($imTag);
                        if ($idImTag > 0) {
                            $hashTagIMUp['idHashTagIM'] = $idHashTagIM;
                            $hashTagIMUp['parsed'] = 1;
                            $this->hashTagIMModel->updateParseHashtagIM($hashTagIMUp);
                        }
                    }
                }
            }
            echo ' - - Fin del proceso.';
        }
        echo '<br> - Tag #' . $hashTagIM . ' - Fin<br>';
    }

    public function getHashTagIMPantalla() {
        $dataPantalla = $this->hashTagIMModel->getHashTagIMPantalla();
        if (!empty($dataPantalla)) {
            $result = 1;
        } else {
            $result = 0;
        }
        $dataResult = array('result' => $result, 'dataPantalla' => $dataPantalla);
        echo json_encode($dataResult);
    }

}
