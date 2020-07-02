<?php
    class TarefaService {
        //CRUD
        //create,read,update,delete
        private $conexao; //ira receber o obj PDO
        private $tarefa;
        
        public function __construct(Conexao $conexao,Tarefa $tarefa){//Se vier um objeto que não seja instancia do obj conexao e do obj tarefa, dará erro
            $this->conexao = $conexao->conectar();
            $this->tarefa = $tarefa;
        }
        public function inserir() {
            //Inserindo a tarefa recebida do post, dentro da coluna 'tarefas' da table 'tb_tarefas'
            $query = 'insert into tb_tarefas(tarefa)values(:tarefa)';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':tarefa',$this->tarefa->__get('tarefa'));//declarando a var :tarefa que foi utilizada 2 linhas acima
            $stmt->execute();
        }
        public function recuperar() {
            /*Recuperando todos os registros do banco de dados e relacionando com a tabela tb_status
            tb_status é guarda se a tarefa está pendente ou ja foi realizada*/
            $query = '
                select 
                    tb_tarefas.id,tb_status.status,tb_tarefas.tarefa 
                from
                    tb_tarefas left join tb_status on(tb_tarefas.id_status = tb_status.id)
                ';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);//pegando somente os nomes associativos do array
        }
        public function atualizar() {
            $query = 'update tb_tarefas set tarefa = ? where id = ?';//Os pontos de interrogação serão definidos abaixo
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1,$this->tarefa->__get('tarefa'));//O 1 ponto de interrogação dentro da query sera substituido pelo valor do obj tarefa
            $stmt->bindValue(2,$this->tarefa->__get('id'));//O 2 ponto de interrogação dentro da query sera substituido pelo valor do obj tarefa
            return $stmt->execute();
        }
        public function remover() {
            $query = 'delete from tb_tarefas where id = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1,$this->tarefa->__get('id'));
            $stmt->execute();
        }
        public function marcarRealizada() {
            $query = 'update tb_tarefas set id_status = 2 where id = ?';//Atualizando a tarefa para uma tarefa realizada
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1,$this->tarefa->__get('id'));
            $stmt->execute();
        }
    }
?>