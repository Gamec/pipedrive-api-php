<?php namespace Benhawker\Pipedrive\Library;

use Benhawker\Pipedrive\Exceptions\PipedriveMissingFieldError;

/**
 * Pipedrive Deals Methods
 *
 * Deals represent ongoing, lost or won sales to an Organization or to a Person.
 * Each deal has a monetary value and must be placed in a Stage. Deals can be
 * owned by a User, and followed by one or many Users. Each Deal consists of
 * standard data fields but can also contain a number of custom fields. The
 * custom fields can be recognized by long hashes as keys. These hashes can be
 * mapped against DealField.key. The corresponding label for each such custom
 * field can be obtained from DealField.name.
 *
 */
class Organizations
{
    /**
     * Hold the pipedrive cURL session
     * @var Curl Object
     */
    protected $curl;

    /**
     * Initialise the object load master class
     */
    public function __construct(\Benhawker\Pipedrive\Pipedrive $master)
    {
        //associate curl class
        $this->curl = $master->curl();
    }

    /**
     * Returns an organization
     *
     * @param  int   $id pipedrive deals id
     * @return array returns detials of a deal
     */
    public function getById($id)
    {
        return $this->curl->get('deals/' . $id);
    }

    /**
     * Adds a deal
     *
     * @param  array $data organization detials
     *
     * @throws \Benhawker\Pipedrive\Exceptions\PipedriveMissingFieldError
     * @return array returns detials of the deal
     */
    public function add(array $data)
    {
        //if there is no title set throw error as it is a required field
        if (!isset($data['title'])) {
            throw new PipedriveMissingFieldError('You must include a "title" feild when inserting a deal');
        }

        return $this->curl->post('deals', $data);
    }

    /**
     * Updates an organization
     *
     * @param  int   $orgId
     * @param  array $data new detials of organization
     *
     * @internal param int $dealId pipedrives organization Id
     * @return array returns detials of an organization
     */
    public function update($orgId, array $data = array())
    {
        return $this->curl->put('organizations/' . $orgId, $data);
    }

    /**
     * Return array of organizations
     *
     * @param int $start
     * @param int $limit
     *
     * @return array
     */
    public function getList($start = 0, $limit = 500) {
        $requestData = [
            "start" => $start,
            "limit" => $limit
        ];
        return $this->curl->get('organizations', $requestData);
    }

}
