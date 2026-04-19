<?php

//prize ladder for all 15 levels.
function prize_ladder(): array
{
    return [
        100, 200, 300, 500, 1000,
        2000, 4000, 8000, 16000, 32000,
        64000, 125000, 250000, 500000, 1000000
    ];
}

//Full question bank split into 3 tiers
function question_bank(): array
{
    return [
        'easy' => [
            ['id' => 'E1', 'question' => 'What sound does a cat most commonly make?', 'options' => ['Woof', 'Meow', 'Moo', 'Buzz'], 'answer' => 'Meow', 'hint' => 'It is the sound people most often associate with house cats.'],
            ['id' => 'E2', 'question' => 'How many lives are cats commonly said to have?', 'options' => ['5', '7', '9', '11'], 'answer' => '9', 'hint' => 'It is a common saying in English.'],
            ['id' => 'E3', 'question' => 'What is a baby cat called?', 'options' => ['Cub', 'Pup', 'Kitten', 'Calf'], 'answer' => 'Kitten', 'hint' => 'It starts with the letter K.'],
            ['id' => 'E4', 'question' => 'Which of these is a common cat behavior?', 'options' => ['Barking', 'Kneading', 'Howling at the moon', 'Building nests'], 'answer' => 'Kneading', 'hint' => 'Cats often do this with their paws on blankets.'],
            ['id' => 'E5', 'question' => 'Which body part helps a cat balance?', 'options' => ['Tail', 'Whiskers', 'Teeth', 'Claws'], 'answer' => 'Tail', 'hint' => 'It is long and moves when they walk on narrow places.'],
            ['id' => 'E6', 'question' => 'What do cats use their whiskers for?', 'options' => ['Decoration', 'Measuring spaces', 'Sharpening claws', 'Cooling down'], 'answer' => 'Measuring spaces', 'hint' => 'They help cats sense openings and nearby objects.'],
            ['id' => 'E7', 'question' => 'What is a group of kittens called?', 'options' => ['School', 'Kindle', 'Pack', 'Colony'], 'answer' => 'Kindle', 'hint' => 'It is an unusual word, not a common animal group term.'],
            ['id' => 'E8', 'question' => 'Cats are usually most active at which times?', 'options' => ['Only noon', 'Dawn and dusk', 'Only midnight', 'Late morning'], 'answer' => 'Dawn and dusk', 'hint' => 'They are crepuscular animals.'],
            ['id' => 'E9', 'question' => 'Which of these is a real cat breed?', 'options' => ['Persian', 'Silkstripe', 'Cloudtail', 'Sunwhisker'], 'answer' => 'Persian', 'hint' => 'It is a long-haired breed.'],
            ['id' => 'E10', 'question' => 'Why do many cats purr?', 'options' => ['To show contentment', 'To breathe better', 'To sharpen teeth', 'To call birds'], 'answer' => 'To show contentment', 'hint' => 'It often happens when they are calm and happy.'],
        ],
        'medium' => [
            ['id' => 'M1', 'question' => 'What is the scientific name of the domestic cat family group?', 'options' => ['Felidae', 'Canidae', 'Equidae', 'Ursidae'], 'answer' => 'Felidae', 'hint' => 'Lions, tigers, and house cats belong to this family.'],
            ['id' => 'M2', 'question' => 'Which wild cat is the fastest land animal?', 'options' => ['Lion', 'Jaguar', 'Cheetah', 'Leopard'], 'answer' => 'Cheetah', 'hint' => 'It is known for speed, not brute strength.'],
            ['id' => 'M3', 'question' => 'What does it usually mean when a cat kneads with its paws?', 'options' => ['Aggression', 'Relaxation or comfort', 'Fear', 'Hunger only'], 'answer' => 'Relaxation or comfort', 'hint' => 'Cats often do it on soft blankets when calm.'],
            ['id' => 'M4', 'question' => 'Which sense is especially strong in cats?', 'options' => ['Taste', 'Hearing', 'Color vision', 'Smell only at night'], 'answer' => 'Hearing', 'hint' => 'Cats can hear very high-pitched sounds.'],
            ['id' => 'M5', 'question' => 'What is the average normal body temperature range for a cat?', 'options' => ['95–97°F', '100–102.5°F', '103–105°F', '107–109°F'], 'answer' => '100–102.5°F', 'hint' => 'It is slightly warmer than a typical human body temperature.'],
            ['id' => 'M6', 'question' => 'Which cat breed is known for having no fur or very little fur?', 'options' => ['Siamese', 'Bengal', 'Sphynx', 'Maine Coon'], 'answer' => 'Sphynx', 'hint' => 'Its name sounds ancient and Egyptian.'],
            ['id' => 'M7', 'question' => 'When a cat slowly blinks at you, it often signals what?', 'options' => ['Warning', 'Trust and affection', 'Illness', 'Hunger'], 'answer' => 'Trust and affection', 'hint' => 'People sometimes call it a cat kiss.'],
            ['id' => 'M8', 'question' => 'Which feature helps cats see better in low light?', 'options' => ['Transparent eyelids', 'Tapetum lucidum', 'Double pupils', 'Night glands'], 'answer' => 'Tapetum lucidum', 'hint' => 'It is a reflective layer in the eye.'],
            ['id' => 'M9', 'question' => 'What is a common reason cats scratch furniture?', 'options' => ['To punish owners', 'To sharpen claws and mark territory', 'To cool down', 'To improve balance'], 'answer' => 'To sharpen claws and mark territory', 'hint' => 'It is both physical maintenance and communication.'],
            ['id' => 'M10', 'question' => 'Which large cat cannot roar?', 'options' => ['Tiger', 'Lion', 'Leopard', 'Cheetah'], 'answer' => 'Cheetah', 'hint' => 'It chirps and purrs instead.'],
        ],
        'hard' => [
            ['id' => 'H1', 'question' => 'What is the scientific name for the domestic cat species?', 'options' => ['Panthera leo', 'Felis catus', 'Lynx lynx', 'Acinonyx jubatus'], 'answer' => 'Felis catus', 'hint' => 'The genus starts with F.'],
            ['id' => 'H2', 'question' => 'Which cat breed is famous for often being born white and developing darker “points” later?', 'options' => ['Persian', 'Siamese', 'Ragdoll', 'Russian Blue'], 'answer' => 'Siamese', 'hint' => 'This breed is strongly associated with blue eyes and point coloration.'],
            ['id' => 'H3', 'question' => 'What structure on a cat’s tongue makes it feel rough?', 'options' => ['Papillae', 'Molars', 'Cartilage pads', 'Taste plates'], 'answer' => 'Papillae', 'hint' => 'These backward-facing structures help with grooming.'],
            ['id' => 'H4', 'question' => 'What is the term for the genetic pattern that creates orange-and-black patchwork coloring in cats?', 'options' => ['Merle', 'Calico', 'Roan', 'Brindle'], 'answer' => 'Calico', 'hint' => 'Most of these cats are female.'],
            ['id' => 'H5', 'question' => 'Which wild cat is most closely associated with the ancestor of the domestic cat?', 'options' => ['European wildcat', 'African wildcat', 'Snow leopard', 'Caracal'], 'answer' => 'African wildcat', 'hint' => 'Its range includes North Africa and the Middle East.'],
            ['id' => 'H6', 'question' => 'What is the term for a cat’s ability to orient itself during a fall?', 'options' => ['Claw reflex', 'Righting reflex', 'Balance loop', 'Landing response'], 'answer' => 'Righting reflex', 'hint' => 'This reflex helps cats twist mid-air.'],
            ['id' => 'H7', 'question' => 'Which cat breed is known for curled-back ears?', 'options' => ['Scottish Fold', 'American Curl', 'Devon Rex', 'Cornish Rex'], 'answer' => 'American Curl', 'hint' => 'The breed name directly refers to the ear shape.'],
            ['id' => 'H8', 'question' => 'What vitamin-related issue can occur if cats are fed a strict dog-style diet for too long?', 'options' => ['Too much vitamin C', 'Taurine deficiency', 'Iron overload', 'Lactose deficiency'], 'answer' => 'Taurine deficiency', 'hint' => 'Cats are obligate carnivores and need this amino acid.'],
            ['id' => 'H9', 'question' => 'Which big cat species is known for being an excellent swimmer?', 'options' => ['Jaguar', 'Cheetah', 'Snow leopard', 'Serval'], 'answer' => 'Jaguar', 'hint' => 'It lives in the Americas and has a very strong bite.'],
            ['id' => 'H10', 'question' => 'What does the term “obligate carnivore” mean for cats?', 'options' => ['They prefer meat', 'They must eat meat to survive', 'They eat only fish', 'They avoid plants at all times'], 'answer' => 'They must eat meat to survive', 'hint' => 'This is a biological requirement, not just a preference.'],
        ],
    ];
}

//starter account data.
function default_accounts(): array
{
    return [];
}