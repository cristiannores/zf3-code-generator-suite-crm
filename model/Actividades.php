<?php

class Actividades {

    public $id;
    public $nombre;
    public $objetivos;
    public $avatar;
    public $duracion;
    public $descripcion;
    public $user_id;
    public $deleted_at;
    public $created_at;
    public $update_at;
    public $avatar_public;
    public $puntaje;

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->nombre = (!empty($data['nombre'])) ? $data['nombre'] : null;
        $this->objetivos = (!empty($data['objetivos'])) ? $data['objetivos'] : null;
        $this->avatar = (!empty($data['avatar'])) ? $data['avatar'] : null;
        $this->duracion = (!empty($data['duracion'])) ? $data['duracion'] : null;
        $this->descripcion = (!empty($data['descripcion'])) ? $data['descripcion'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->deleted_at = (!empty($data['deleted_at'])) ? $data['deleted_at'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->update_at = (!empty($data['update_at'])) ? $data['update_at'] : null;
        $this->puntaje = (!empty($data['puntaje'])) ? $data['puntaje'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
