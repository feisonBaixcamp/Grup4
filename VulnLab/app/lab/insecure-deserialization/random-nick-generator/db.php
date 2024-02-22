<?php
 
class DB {

    private $userlist;

    public function __construct() {
        // Inicializar la lista de usuarios con los datos correspondientes
        $this->userlist = array(
            0 => array(
                'username' => md5('administrator'),
                'password' => md5('a2T%tq+<=VuLJh8,}fBwU@Qttn+YR{rq')
            ),
            1 => array(
                'username' => 'test',
                'password' => md5('test'),
            )
        );
    }

    // Método para obtener la lista de usuarios
    public function getUsersList() {
        return $this->userlist;
    }
}
?>
