<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Habilidades Model
 *
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsToMany $Usuarios
 *
 * @method \App\Model\Entity\Habilidade get($primaryKey, $options = [])
 * @method \App\Model\Entity\Habilidade newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Habilidade[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Habilidade|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Habilidade saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Habilidade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Habilidade[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Habilidade findOrCreate($search, callable $callback = null, $options = [])
 */
class HabilidadesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('habilidades');
        $this->setDisplayField('nombre');
        $this->setPrimaryKey('id_habilidad');

        $this->belongsToMany('Usuarios', [
            'foreignKey' => 'habilidad_id',
            'targetForeignKey' => 'usuario_id',
            'joinTable' => 'habilidades_usuarios',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmptyString('id_habilidad', null, 'create');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 100)
            ->allowEmptyString('nombre');

        $validator
            ->scalar('descripcion')
            ->allowEmptyString('descripcion');

        $validator
            ->integer('nivel')
            ->allowEmptyString('nivel');

        $validator
            ->scalar('fichero')
            ->allowEmptyString('fichero');

        return $validator;
    }
}
