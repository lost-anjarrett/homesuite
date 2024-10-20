<?php

namespace App\Form\DataTransformer;

use App\Entity\RecipeTag;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class RecipeTagsTransformer implements DataTransformerInterface
{

    /**
     * @var ObjectManager
     */
    private $manager;

//    public function __construct(ObjectManager $manager)
//    {
//        $this->manager = $manager;
//    }

    public function transform($value): string
    {
        return implode(',', $value);
    }

    public function reverseTransform($string): array
    {
        $names = array_unique(array_filter(array_map('trim', explode(',', $string))));
        $tags = $this->manager->getRepository(RecipeTag::class)->findBy([
            'name' => $names
        ]);
        $newNames = array_diff($names, $tags);
        foreach ($newNames as $name) {
            $tag = new RecipeTag();
            $tag->setName($name);
            $tags[] = $tag;
        }
        return $tags;
    }
}
