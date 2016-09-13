<?php
namespace Scherersoftware\CakePushNotifications\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Feedback Model
 *
 * @method \CakePushNotifications\Model\Entity\Feedback get($primaryKey, $options = [])
 * @method \CakePushNotifications\Model\Entity\Feedback newEntity($data = null, array $options = [])
 * @method \CakePushNotifications\Model\Entity\Feedback[] newEntities(array $data, array $options = [])
 * @method \CakePushNotifications\Model\Entity\Feedback|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CakePushNotifications\Model\Entity\Feedback patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CakePushNotifications\Model\Entity\Feedback[] patchEntities($entities, array $data, array $options = [])
 * @method \CakePushNotifications\Model\Entity\Feedback findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FeedbackTable extends Table
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

        $this->table('feedback');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('platform', 'create')
            ->notEmpty('platform');

        return $validator;
    }

    public function processResponse($response)
    {
        if (is_a($response, 'ZendService\Apple\Apns\Response\Message')) {
            $this->__processApnsResponse($response);
        }
        if (is_a($response, 'ZendService\Google\Gcm\Response')) {
            $this->__processFcmResponse($response);
        }
    }

    private function __processFcmResponse($response)
    {
        $entity = $this->newEntity();
        $entity->platform = 'android';
        debug($response->getResponse());exit;
        $this->save($entity);
    }

    private function __processApnsResponse($response)
    {
        $entity = $this->newEntity();
        $entity->platform = 'ios';
        debug($response);exit;
        $this->save($entity);
    }
}
