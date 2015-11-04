<?php
namespace Nebo15\LumenIntercom;

use Intercom\IntercomBasicAuthClient;

/**
 * Class Intercom
 * @property  $intercom_service
 * @method getAdmins()
 * @method getCompanies()
 * @method getCompany(array $data = [])
 * @method getCompanyUsers(array $data = [])
 * @method getCompanyUsersByCompanyID(array $data = [])
 * @method createCompany(array $data = [], $execute_on_terminate = false)
 * @method updateCompany(array $data = [], $execute_on_terminate = false)
 * @method getContact(array $data = [])
 * @method getContacts(array $data = [])
 * @method convertContact(array $data = [], $execute_on_terminate = false)
 * @method updateContact(array $data = [], $execute_on_terminate = false)
 * @method createContact(array $data = [], $execute_on_terminate = false)
 * @method deleteContact(array $data = [], $execute_on_terminate = false)
 * @method createMessage(array $data = [], $execute_on_terminate = false)
 * @method getConversation(array $data = [])
 * @method getConversations(array $data = [])
 * @method replyToConversation(array $data = [])
 * @method markConversationAsRead(array $data = [], $execute_on_terminate = false)
 * @method getCounts()
 * @method getConversationCount()
 * @method getAdminConversationCount()
 * @method getUserTagCount()
 * @method getUserSegmentCount()
 * @method getCompanyUserCount()
 * @method getCompanySegmentCount()
 * @method getCompanyTagCount()
 * @method createEvent(array $data = [], $execute_on_terminate = false)
 * @method getNotesForUser(array $data = [])
 * @method getNote(array $data = [])
 * @method createNote(array $data = [], $execute_on_terminate = false)
 * @method getSegments()
 * @method getSegment(array $data = [])
 * @method getTags()
 * @method createTag(array $data = [], $execute_on_terminate = false)
 * @method updateTag(array $data = [], $execute_on_terminate = false)
 * @method tagUsers(array $data = [], $execute_on_terminate = false)
 * @method tagCompanies(array $data = [], $execute_on_terminate = false)
 * @method getUser(array $data = [])
 * @method getUsers(array $data = [])
 * @method createUser(array $data = [], $execute_on_terminate = false)
 * @method updateUser(array $data = [], $execute_on_terminate = false)
 * @method deleteUser(array $data = [], $execute_on_terminate = false)
 * @package Nebo15\LumenIntercom
 */
class Intercom
{
    private $app_id = null;
    private $app_key = null;
    private $intercom_service = null;
    private $execute_on_terminate_list = [];

    public function __construct($app_id, $app_key)
    {
        $this->app_id = $app_id;
        $this->app_key = $app_key;
        $this->createIntercomInstance();
    }

    public function __call($method, $args)
    {
        if (isset($args[1]) && true === $args[1]) {
            return $this->addMethodToTerminateList($method, $args[0]);
        } else {
            return $this->intercom_service->{$method}($args[0]);
        }
    }

    public function sendCollectedEvents()
    {
        foreach ($this->execute_on_terminate_list as $data)
        {
            $this->intercom_service->{$data['method']}($data['params']);
        }
    }

    private function addMethodToTerminateList($method, $params)
    {
        $this->execute_on_terminate_list[] = [
            'method' => $method,
            'params' => $params,
        ];
        return $this;
    }

    private function createIntercomInstance()
    {
        $this->intercom_service = IntercomBasicAuthClient::factory([
            'app_id' => $this->app_id,
            'api_key' => $this->app_key,
        ]);
    }
}