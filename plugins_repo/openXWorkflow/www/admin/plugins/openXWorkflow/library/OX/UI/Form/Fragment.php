<?php

/**
 * Defines a larger fragment of a form. A fragment can range from one form element, through
 * one form line to multiple form lines and display groups. A fragment has a number of
 * form life cycle methods that will be called on various stages of form processing.
 * 
 * See OX_UI_Form_Fragment_Default for an empty implementation of this interface.
 * 
 * TODO: In the future we may want to keep a reference to the form internally and proxy
 * form-creating methods from the fragment to the backing form. This will allow us to
 * transparently capture the names of elements, lines and display groups the fragment
 * is managing. This will be useful to make fragments true components. Without capturing
 * fragment elements' names, we can't use arbitrary fragments as subfragments of an 
 * alternative fragment because the enclosing alternative fragment woudn't know the names
 * of elements added by the child fragment (which doesn't have to be aware of the
 * fact that it's being embedded in the alternative fragment that manipulates visibility
 * and validation of the elements).
 */
interface OX_UI_Form_Fragment
{
    /**
     * This method should build this fragment's UI by adding all required elements,
     * lines and display groups to the provided form. This method is called right after
     * this fragment has been added to the form.
     * 
     * Note that OX_UI_Form::addDisplayGroup() can be called multiple times with the same 
     * display group name, in which case elements will be added to the already existing 
     * display group.
     *
     * @param OX_UI_Form $form the form to which this fragment's elements should be added
     * @param array $values current request parameters, useful to fill-in form elements
     *         with 'current' values. 
     */
    public function build(OX_UI_Form $form, array $values);
    
    /**
     * Performs fragment-specific validation. This method is called when form values are 
     * validated, and only if the default form validation passes and all previously processed 
     * fragments are valid. You need to implement this method only if this fragment needs 
     * more complex validation that is beyond validating individual elements.
     *
     * @param OX_UI_Form $form form being validated
     * @param array $values current request parameters for which validation is performed
     * @return true if this fragment is valid
     */
    public function validate(OX_UI_Form $form, array $values);

    /**
     * Populates the backing object after form submission. This method will be called
     * only if form has been submitted and all provided values are valid.
     * 
     * @param OX_UI_Form $form form to take values from
     */
    public function populate(OX_UI_Form $form);
    
    /**
     * Called before the form containing this fragment is rendered.
     */
    public function render(OX_UI_Form $form);
}
