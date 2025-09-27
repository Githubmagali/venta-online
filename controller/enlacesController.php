<?php


class enlacesController
{

    public function enlacesController()
    {

        $enlace = isset($_GET['view']) ? $_GET['view'] : 'index';

        $resp = enlacesModel::enlacesModel($enlace);

        include $resp;
    }
}
