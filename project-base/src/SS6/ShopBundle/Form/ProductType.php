<?php

namespace SS6\ShopBundle\Form;

use SS6\ShopBundle\Component\Transformers\ProductIdToProductTransformer;
use SS6\ShopBundle\Component\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType {

	/**
	 * @var \SS6\ShopBundle\Component\Transformers\ProductIdToProductTransformer
	 */
	private $productIdToProductTransformer;

	/**
	 * @var \SS6\ShopBundle\Component\Translation\Translator
	 */
	private $translator;

	public function __construct(
		ProductIdToProductTransformer $productIdToProductTransformer,
		Translator $translator
	) {
		$this->productIdToProductTransformer = $productIdToProductTransformer;
		$this->translator = $translator;
	}

	/**
	 * @param \Symfony\Component\Form\FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->addModelTransformer($this->productIdToProductTransformer);
	}

	/**
	 * @param \Symfony\Component\Form\FormView $view
	 * @param \Symfony\Component\Form\FormInterface $form
	 * @param array $options
	 */
	public function buildView(FormView $view, FormInterface $form, array $options) {
		parent::buildView($view, $form, $options);

		$view->vars['placeholder'] = $options['placeholder'];
		$view->vars['enableRemove'] = $options['enableRemove'];
		$view->vars['allow_variants'] = var_export($options['allow_variants'], true);

		$product = $form->getData();
		if ($product !== null) {
			/* @var $product \SS6\ShopBundle\Model\Product\Product */
			$view->vars['productName'] = $product->getName();
		}
	}

	/**
	 * @return string
	 */
	public function getParent() {
		return 'hidden';
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'product';
	}

	/**
	 * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults([
			'placeholder' => $this->translator->trans('Vyberte produkt'),
			'enableRemove' => false,
			'required' => true,
			'allow_variants' => true,
		]);
	}

}
