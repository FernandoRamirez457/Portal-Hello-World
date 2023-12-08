<?php
    function conectar(){
        $host = 'fdb1032.awardspace.net';
        $usuario = '4050487_bdportal';
        $senha = '2InfoNet123@';
        $bd = '4050487_bdportal';

        // realizar a conexão 
        $conection = mysqli_connect($host, $usuario, $senha, $bd);
        return $conection;
   }
 
    function fecharConexao($conexao){
        mysqli_close($conexao);
    }
?>
