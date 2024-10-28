<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Habilidade Entity
 *
 * @property int $id_habilidad
 * @property string|null $nombre
 * @property string|null $descripcion
 * @property int|null $nivel
 * @property string|null $fichero
 *
 * @property \App\Model\Entity\Usuario[] $usuarios
 */
class Habilidade extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'descripcion' => true,
        'nivel' => true,
        'fichero' => true,
        'usuarios' => true,
    ];
}
