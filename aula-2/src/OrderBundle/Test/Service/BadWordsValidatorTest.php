<?php

namespace OrderBundle\Entity\Test;

use OrderBundle\Repository\BadWordsRepository;
use OrderBundle\Service\BadWordsValidator;
use PHPUnit\Framework\TestCase;

class BadWordsValidatorTest extends TestCase {

    /**
     * Working with stubs, objects that simulate real scenarios, mostly used as a method thar return things
     * @dataProvider BadWordsDataProvider
     */
    public function testIsBadWord(){
        $badWordsRepository = $this->createMock(BadWordsRepository::class);
        $badWordsRepository->method('findAllAsArray')->willReturn(['fuck', 'shit', 'ass']);

        $badWordsValidator = new BadWordsValidator($badWordsRepository);

        $hasBadWords = $badWordsValidator->hasBadWords('fuck you');

        $this->assertEquals(true, $hasBadWords);
    }

    public function BadWordsDataProvider(){
        return [
            'shouldFindWhenHasBadWords' => [
                'BadWordsList' => ['fuck', 'shit', 'ass'],
                'text' => 'fuck you',
                'foundBadWords' => true
            ],
            'shouldNotFindWhenHasNoBadWords' => [
                'BadWordsList' => ['fuck', 'shit', 'ass'],
                'text' => 'hey you',
                'foundBadWords' => false
            ],
            'shouldNotFindWhenTextIsEmpty' => [
                'BadWordsList' => ['fuck', 'shit', 'ass'],
                'text' => '',
                'foundBadWords' => false
            ],
            'shouldNotFindWhenBadWordsListIsEmpty' => [
                'BadWordsList' => [],
                'text' => 'fuck you',
                'foundBadWords' => false
            ],
        ];
    }
}