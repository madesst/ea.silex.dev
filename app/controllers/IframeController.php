<?php
/**
 * Created by PhpStorm.
 * User: madesst
 * Date: 28.09.13
 * Time: 17:15
 */

namespace EA;

use Aws\Ses\Exception\MessageRejectedException;
use Aws\Ses\SesClient;
use Model\Token;
use Model\User;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomeController extends BaseController
{
	public function indexAction($source_id)
	{
		$user = new User();

		$form = $this->app['form.factory']->createNamedBuilder('user', 'form', $user, array('data_class' => 'Model\User'))
			->add('username', 'text', array(
				'label' => 'Имя:',
				'constraints' => array(new NotBlank()),
				'attr' => array(
					'class' => 'field'
				)
			))
			->add('email', 'text', array(
					'label' => 'Email:',
					'constraints' => array(new NotBlank(), new Email(), new Length(array('min' => 4, 'max' => 50))),
					'attr' => array(
						'class' => 'field'
					)
				)
			)
			->add('birthdate', 'date', array(
				'label' => 'Укажите вашу дату рождения',
				'widget' => 'choice',
				'input' => 'datetime',
				'years' => range(date('Y') - 5, date('Y') - 90),
				'format' => 'dd MMMM yyyy',
				'empty_value' => array('year' => 'Год', 'month' => 'Месяц', 'day' => 'День'),
				'view_timezone' => 'Europe/Moscow',
				'attr' => array(
					'class' => 'birthdate'
				)
			))
			->getForm();

		if ('POST' == $this->app['request']->getMethod()) {
			$form->bind($this->app['request']);

			if ($form->isValid()) {
				$user = $form->getData();

				if ($user->getAge() < 14) {
					return $this->render('iframe/error/age');
				}

				$em = $this->app['orm.em'];
				$exist_user = $em->getRepository('Model\User')->findByEmail($user->getEmail());

				if ($exist_user) {
					if ($exist_user->getActive()) {
						return $this->render('iframe/error/already');
					}
					return $this->render('iframe/error/email');
				}

				$timestamp = new \DateTime();
				$timestamp->setTimestamp(time());

				$user->setCreatedAt($timestamp);
				$user->setSourceId($source_id);

				$token = new Token();
				$token->setCreatedAt($timestamp);
				$token->setUser($user);
				$token->setValue(md5(time() . $user->getId() . $user->getEmail()));

				try {
					$this->getSesClient()->sendEmail(array(
						'Source' => 'betainvite@electronicarts.ru',
						'Destination' => array(
							'ToAddresses' => array($user->getEmail()),
						),
						'Message' => array(
							'Subject' => array(
								'Data' => 'Подтверждение Email для Закрытого Бета-теста FIFA World',
							),
							'Body' => array(
								'Html' => array(
									'Data' => $this->render('email/token', array('token' => $token, 'user' => $user)),
									'Charset' => 'UTF-8',
								),
							),
						)
					));
				} catch (MessageRejectedException $e) {
					if ($e->getMessage() == 'Email address is not verified.') {
						$this->getSesClient()->verifyEmailAddress(array('EmailAddress' => $user->getEmail()));
						return $this->render('iframe/error/ses');
					}
				}

				$em->persist($user);
				$em->persist($token);
				$em->flush();

				return $this->render('iframe/success');
			}
		}

		return $this->render('iframe/index', array('form' => $form->createView(), 'source_id' => $source_id));
	}

	public function confirmAction($token_string)
	{
		$em = $this->app['orm.em'];
		$token = $em->getRepository('Model\Token')->findForConfirmation($token_string);

		if (!$token) {
			return $this->render('iframe/error/token');
		}

		$key = $em->getRepository('Model\Key')->findRandom();

		if (!$key) {
			return $this->render('iframe/error/key');
		}

		$timestamp = new \DateTime();
		$timestamp->setTimestamp(time());

		$token->setActive(false);
		$token->setUpdatedAt($timestamp);

		$user = $token->getUser();
		$user->setActive(true);

		$key->setUser($user);
		$key->setActive(false);

		$this->getSesClient()->sendEmail(array(
			'Source' => 'betainvite@electronicarts.ru',
			'Destination' => array(
				'ToAddresses' => array($user->getEmail()),
			),
			'Message' => array(
				'Subject' => array(
					'Data' => 'Ваш ключ для Закрытого Бета-теста FIFA World',
				),
				'Body' => array(
					'Html' => array(
						'Data' => $this->render('email/key', array('key' => $key)),
						'Charset' => 'UTF-8',
					),
				),
			)
		));

		$em->persist($user);
		$em->persist($key);
		$em->persist($token);
		$em->flush();

		return $this->render('iframe/confirm');
	}

	public function reportAction()
	{
		$report_data = $this->app['orm.em']->getRepository('Model\User')->retrieveReportData();
		return $this->render('report/index', array('report' => $report_data));
	}

	public function bootstrapAction()
	{
		return '';
	}

	protected function getSesClient()
	{
		return SesClient::factory(array(
			'key' => 'AKIAJEGI65CUTZXY6VDQ',
			'secret' => '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',
			'region' => 'us-east-1'
		));
	}
}
