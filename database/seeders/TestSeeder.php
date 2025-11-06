<?php

namespace Database\Seeders;

use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // Тест 1: Основы программной инженерии
        $test1 = Test::create([
            'title' => 'Основы программной инженерии',
            'description' => 'Проверка знаний основных понятий программной инженерии',
            'order' => 1,
            'passing_score' => 70,
            'duration' => 15
        ]);

        $this->createQuestions($test1, [
            [
                'content' => 'Что такое программная инженерия?',
                'answers' => [
                    ['text' => 'Инженерная дисциплина, изучающая вопросы построения компьютерных программ', 'is_correct' => true],
                    ['text' => 'Наука о компьютерах', 'is_correct' => false],
                    ['text' => 'Процесс написания программного кода', 'is_correct' => false],
                    ['text' => 'Метод управления IT-проектами', 'is_correct' => false],
                ],
                'explanation' => 'Программная инженерия — это инженерная дисциплина, которая изучает вопросы построения компьютерных программ и охватывает все аспекты их создания.'
            ],
            [
                'content' => 'Чем отличается программное обеспечение от программного продукта?',
                'answers' => [
                    ['text' => 'Программный продукт готов к продаже и имеет документацию', 'is_correct' => true],
                    ['text' => 'Это одно и то же', 'is_correct' => false],
                    ['text' => 'ПО дороже программного продукта', 'is_correct' => false],
                    ['text' => 'Программный продукт нельзя модифицировать', 'is_correct' => false],
                ],
                'explanation' => 'Программный продукт — это ПО, прошедшее полный цикл разработки, готовое к продаже и имеющее необходимую документацию.'
            ]
        ]);

        // Тест 2: Требования в разработке ПО
        $test2 = Test::create([
            'title' => 'Требования в разработке ПО',
            'description' => 'Проверка знаний о работе с требованиями',
            'order' => 2,
            'passing_score' => 75,
            'duration' => 20
        ]);

        $this->createQuestions($test2, [
            [
                'content' => 'Что такое функциональные требования?',
                'answers' => [
                    ['text' => 'Требования, описывающие что делает система', 'is_correct' => true],
                    ['text' => 'Требования к производительности системы', 'is_correct' => false],
                    ['text' => 'Требования к интерфейсу', 'is_correct' => false],
                    ['text' => 'Требования к безопасности', 'is_correct' => false],
                ],
                'explanation' => 'Функциональные требования описывают конкретные действия и функции, которые должна выполнять система.'
            ],
            [
                'content' => 'Какой критерий НЕ является обязательным для хорошего требования?',
                'answers' => [
                    ['text' => 'Краткость', 'is_correct' => true],
                    ['text' => 'Тестируемость', 'is_correct' => false],
                    ['text' => 'Однозначность', 'is_correct' => false],
                    ['text' => 'Реализуемость', 'is_correct' => false],
                ],
                'explanation' => 'Хотя краткость желательна, главные критерии — это тестируемость, однозначность и реализуемость требования.'
            ]
        ]);

        // Тест 3: Методологии разработки
        $test3 = Test::create([
            'title' => 'Методологии разработки',
            'description' => 'Проверка знаний об Agile, Scrum и других методологиях',
            'order' => 3,
            'passing_score' => 80,
            'duration' => 25
        ]);

        $this->createQuestions($test3, [
            [
                'content' => 'Что такое спринт в Scrum?',
                'answers' => [
                    ['text' => 'Фиксированный по времени период разработки', 'is_correct' => true],
                    ['text' => 'Ежедневное совещание команды', 'is_correct' => false],
                    ['text' => 'Список задач проекта', 'is_correct' => false],
                    ['text' => 'Финальное тестирование', 'is_correct' => false],
                ],
                'explanation' => 'Спринт — это фиксированный по времени период (обычно 2-4 недели), в течение которого команда работает над определенным набором задач.'
            ],
            [
                'content' => 'Какое утверждение об Agile верно?',
                'answers' => [
                    ['text' => 'Работающий продукт важнее исчерпывающей документации', 'is_correct' => true],
                    ['text' => 'Документация важнее работающего продукта', 'is_correct' => false],
                    ['text' => 'План важнее адаптивности', 'is_correct' => false],
                    ['text' => 'Контракт важнее сотрудничества', 'is_correct' => false],
                ],
                'explanation' => 'Согласно Agile-манифесту, работающий продукт ценится выше исчерпывающей документации.'
            ]
        ]);

        // Тест 4: Управление проектом
        $test4 = Test::create([
            'title' => 'Управление проектом',
            'description' => 'Проверка знаний о проектном управлении в IT',
            'order' => 4,
            'passing_score' => 75,
            'duration' => 20
        ]);

        $this->createQuestions($test4, [
            [
                'content' => 'Какой фактор НЕ входит в тройное ограничение проекта?',
                'answers' => [
                    ['text' => 'Количество разработчиков', 'is_correct' => true],
                    ['text' => 'Время', 'is_correct' => false],
                    ['text' => 'Бюджет', 'is_correct' => false],
                    ['text' => 'Содержание', 'is_correct' => false],
                ],
                'explanation' => 'Тройное ограничение проекта включает время, бюджет и содержание (scope). Количество разработчиков - это ресурс, влияющий на эти ограничения.'
            ],
            [
                'content' => 'Что такое критический путь в проекте?',
                'answers' => [
                    ['text' => 'Самая длинная последовательность задач от начала до конца проекта', 'is_correct' => true],
                    ['text' => 'Список наиболее важных задач', 'is_correct' => false],
                    ['text' => 'Путь с наибольшим риском', 'is_correct' => false],
                    ['text' => 'Самый короткий путь выполнения проекта', 'is_correct' => false],
                ],
                'explanation' => 'Критический путь - это последовательность задач, определяющая минимальную продолжительность проекта. Задержка любой задачи на критическом пути приведет к задержке всего проекта.'
            ]
        ]);

        // Тест 5: Принципы и практики разработки
        $test5 = Test::create([
            'title' => 'Принципы и практики разработки',
            'description' => 'Проверка знаний о принципах и лучших практиках разработки',
            'order' => 5,
            'passing_score' => 80,
            'duration' => 25
        ]);

        $this->createQuestions($test5, [
            [
                'content' => 'Что такое принцип DRY?',
                'answers' => [
                    ['text' => 'Don\'t Repeat Yourself - не повторяйся', 'is_correct' => true],
                    ['text' => 'Do Review Yourself - проверяй себя', 'is_correct' => false],
                    ['text' => 'Document Really Yearly - документируй ежегодно', 'is_correct' => false],
                    ['text' => 'Design Reasonable Yield - проектируй разумную производительность', 'is_correct' => false],
                ],
                'explanation' => 'DRY (Don\'t Repeat Yourself) - это принцип разработки ПО, нацеленный на снижение повторения информации всех видов.'
            ],
            [
                'content' => 'Какое утверждение о чистом коде верно?',
                'answers' => [
                    ['text' => 'Чистый код легко читать и понимать другим разработчикам', 'is_correct' => true],
                    ['text' => 'Чистый код всегда работает максимально быстро', 'is_correct' => false],
                    ['text' => 'Чистый код содержит много комментариев', 'is_correct' => false],
                    ['text' => 'Чистый код занимает минимум места', 'is_correct' => false],
                ],
                'explanation' => 'Чистый код должен быть понятным и легко читаемым для других разработчиков. Это важнее, чем производительность или размер кода.'
            ]
        ]);

        // Итоговый экзамен
        $finalExam = Test::create([
            'title' => 'Итоговый экзамен по программной инженерии',
            'description' => 'Комплексная проверка знаний по всем темам курса',
            'order' => 6,
            'passing_score' => 85,
            'duration' => 45,
            'is_final_exam' => true
        ]);

        $this->createQuestions($finalExam, [
            [
                'content' => 'Какие из перечисленных являются основными этапами жизненного цикла ПО?',
                'type' => 'multiple',
                'answers' => [
                    ['text' => 'Анализ требований', 'is_correct' => true],
                    ['text' => 'Проектирование', 'is_correct' => true],
                    ['text' => 'Кодирование', 'is_correct' => true],
                    ['text' => 'Маркетинг', 'is_correct' => false],
                ],
                'explanation' => 'Основные этапы жизненного цикла ПО включают анализ требований, проектирование, реализацию (кодирование), тестирование и сопровождение.'
            ],
            [
                'content' => 'Опишите основные принципы Agile-манифеста',
                'type' => 'text',
                'answers' => [
                    ['text' => 'Люди и взаимодействие важнее процессов и инструментов. Работающий продукт важнее исчерпывающей документации. Сотрудничество с заказчиком важнее согласования условий контракта. Готовность к изменениям важнее следования первоначальному плану.', 'is_correct' => true],
                ],
                'explanation' => 'Это четыре основные ценности Agile-манифеста, которые определяют гибкий подход к разработке.'
            ],
            [
                'content' => 'Почему важно управление требованиями в проекте?',
                'type' => 'text',
                'answers' => [
                    ['text' => 'Управление требованиями критично для успеха проекта, так как оно обеспечивает четкое понимание целей, позволяет контролировать изменения, помогает оценивать прогресс и гарантирует, что конечный продукт соответствует ожиданиям заказчика.', 'is_correct' => true],
                ],
                'explanation' => 'Хорошее управление требованиями - ключ к успешной реализации проекта и удовлетворению потребностей заказчика.'
            ]
        ]);

        // Связываем тесты как предварительные требования
        $test2->requiredTests()->attach($test1->id);
        $test3->requiredTests()->attach($test2->id);
        $test4->requiredTests()->attach($test3->id);
        $test5->requiredTests()->attach($test4->id);
        
        // Для итогового экзамена требуются все предыдущие тесты
        $finalExam->requiredTests()->attach([
            $test1->id,
            $test2->id,
            $test3->id,
            $test4->id,
            $test5->id
        ]);
    }

    private function createQuestions($test, $questionsData)
    {
        foreach ($questionsData as $questionData) {
            $question = Question::create([
                'test_id' => $test->id,
                'content' => $questionData['content'],
                'type' => 'single',
                'explanation' => $questionData['explanation']
            ]);

            foreach ($questionData['answers'] as $answerData) {
                $answer = Answer::create([
                    'question_id' => $question->id,
                    'content' => $answerData['text'],
                    'is_correct' => $answerData['is_correct']
                ]);

                if ($answerData['is_correct']) {
                    $question->correct_answer_id = $answer->id;
                    $question->save();
                }
            }
        }
    }
}