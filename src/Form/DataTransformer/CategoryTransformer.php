<?php

namespace App\Form\DataTransformer;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CategoryTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Transforms an object (category) to a string (number)
     *
     * @param Category|null $category
     * @return string
     */
    public function transform($category): string
    {
        if (null === $category)
        {
            return '';
        }

        return $category->getName();
    }

    /**
     *
     * Transforms a string (name) to an object (issue)
     *
     * @param mixed $categoryName
     * @return Category|null
     * @throws TransformationFailedException if object (issue) is not found
     */
    public function reverseTransform($categoryName): ?Category
    {
        // no category name? It's optional, so that's ok
        if(!$categoryName)
        {
            return null;
        }

        // query for the issue with this id
        $category = $this->entityManager->getRepository(Category::class)
            ->findOneBy(array("name" => $categoryName));

        if(null === $category) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            /*            throw new TransformationFailedException(sprintf(
                            'An issue with number "%s" does not exist!',
                            $issueNumber
                        ));*/

            $privateErrorMessage = sprintf('A category with name "%s" does not exist!', $categoryName);
            $publicErrorMessage = 'The given "{{ value }}" value is not a valid category name.';

            $failure = new TransformationFailedException($privateErrorMessage);
            $failure->setInvalidMessage($publicErrorMessage, [
                '{{ value }}' => $categoryName,
            ]);

            throw $failure;
        }

        return $category;
    }

}