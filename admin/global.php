<?php
function my_money_format($formato, $valor) {
    // Se a funcao my_money_format esta disponivel: usa-la
    if (function_exists('money_format')) {
        return money_format($formato, $valor);
    } else return $valor ."USD";
}
if(!isset($_SESSION[admin_uid]))
{
	session_destroy();
	header("location: ../admin/");
}
?>