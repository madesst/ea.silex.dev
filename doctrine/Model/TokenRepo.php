<?php

namespace Model;

use Doctrine\ORM\EntityRepository;

/**
 * TokenRepo
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TokenRepo extends EntityRepository
{
	public function findForConfirmation($token_string)
	{
		return $this->findOneBy(array('value' => $token_string, 'active' => true));
	}
}
