<?php

declare(strict_types=1);

namespace SimpleSAML\SAML2\XML\saml;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SAML2\Constants as C;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing SAML2 AuthnContextDecl
 *
 * @package simplesamlphp/saml2
 */
final class AuthnContextDecl extends AbstractSamlElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = C::XS_ANY_NS_ANY;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = C::XS_ANY_NS_ANY;


    /**
     * Initialize an AuthnContextDecl.
     *
     * @param \SimpleSAML\XML\Chunk[] $elements
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    public function __construct(array $elements = [], array $attributes = [])
    {
        $this->setElements($elements);
        $this->setAttributesNS($attributes);
    }



    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getAttributesNS())
            && empty($this->getElements());
    }


    /**
     * Convert XML into a AuthnContextDecl
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'AuthnContextDecl', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, AuthnContextDecl::NS, InvalidDOMElementException::class);

        $elements = [];
        foreach ($xml->childNodes as $element) {
            if ($element->namespaceURI === C::NS_SAML) {
                continue;
            } elseif (!($element instanceof DOMElement)) {
                continue;
            }

            $elements[] = new Chunk($element);
        }

        return new static($elements, self::getAttributesNSFromXML($xml));
    }


    /**
     * Convert this AuthContextDecl to XML.
     *
     * @param \DOMElement|null $parent The element we should append this AuthnContextDecl to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getElements() as $element) {
            /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $element */
            $element->toXML($e);
        }

        return $e;
    }
}
