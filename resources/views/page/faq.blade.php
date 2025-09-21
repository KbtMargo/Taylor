{{-- @extends('layouts.app') --}}

@section('title','FAQ | DressCode')

@section('content')
<div class="container py-1">
  <div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
      
      <div class="text-center mb-5">
        <h1 class="fw-bold mb-3">Поширені запитання</h1>
        <p class="text-muted">Знайдіть відповіді на найпопулярніші запитання про наш сервіс</p>
      </div>

      <div class="accordion" id="faqAccordion">
        
        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q1">
            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a1" aria-expanded="true" aria-controls="a1">
              Як знайти підходящого майстра?
            </button>
          </h2>
          <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion" aria-labelledby="q1">
            <div class="accordion-body text-muted">
              <p>Скористайтесь фільтрами пошуку: оберіть тип виробу (сукня, костюм, верхній одяг), бюджет, місто та бажані строки. Перегляньте портфоліо майстрів, зверніть увагу на спеціалізацію та реальні фото робіт.</p>
              <p class="mb-0">Читайте відгуки та рейтинги — вони допоможуть зрозуміти якість сервісу, стиль виконання й комунікацію майстра.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q2">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a2" aria-expanded="false" aria-controls="a2">
              Як оформити замовлення на індивідуальний пошив?
            </button>
          </h2>
          <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q2">
            <div class="accordion-body text-muted">
              <p>На сторінці майстра натисніть <strong>«Створити замовлення»</strong>, опишіть виріб, прикріпіть референси, вкажіть терміни та бюджет. Після відправлення майстер відповість у чаті для уточнення деталей.</p>
              <p class="mb-0">Коли умови погоджені, підтвердьте замовлення у своєму кабінеті — система зафіксує дедлайни та етапи роботи.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q3">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a3" aria-expanded="false" aria-controls="a3">
              Як здійснюється оплата?
            </button>
          </h2>
          <div id="a3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q3">
            <div class="accordion-body text-muted">
              <p>Оплата проходить через безпечний платіжний шлюз (банківські картки, Apple Pay/Google Pay). Зазвичай передбачена передоплата, решта — після затвердження примірки або завершення роботи.</p>
              <p class="mb-0">Усі транзакції фіксуються в системі, що забезпечує прозорість і захист як клієнта, так і майстра.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q4">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a4" aria-expanded="false" aria-controls="a4">
              Скільки часу займає виготовлення одягу?
            </button>
          </h2>
          <div id="a4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q4">
            <div class="accordion-body text-muted">
              <p>Стандартні терміни — від 7 до 21 дня залежно від складності виробу та завантаженості майстра. Для термінових замовлень можливий прискорений режим за узгодженням.</p>
              <p class="mb-0">Конкретні дати ви бачите в картці замовлення, а етапи роботи — у таймлайні проєкту.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q5">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a5" aria-expanded="false" aria-controls="a5">
              Чи можна замовити матеріал через платформу?
            </button>
          </h2>
          <div id="a5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q5">
            <div class="accordion-body text-muted">
              <p>Так, багато майстрів пропонують підбір і закупівлю тканин. Ви можете обрати матеріал із каталогу або надати власний.</p>
              <p class="mb-0">За потреби майстер підбере альтернативи в межах бюджету та надішле зразки для погодження.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q6">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a6" aria-expanded="false" aria-controls="a6">
              Що робити, якщо результат не влаштовує?
            </button>
          </h2>
          <div id="a6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q6">
            <div class="accordion-body text-muted">
              <p>Спочатку обговоріть правки з майстром — зазвичай передбачене безкоштовне коригування (підгонка, дрібні зміни). У випадку суттєвих розбіжностей із погодженим технічним завданням зверніться до підтримки.</p>
              <p class="mb-0">Платформа має політику часткового/повного відшкодування, якщо порушені ключові умови договору.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q7">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a7" aria-expanded="false" aria-controls="a7">
              Як стати майстром на платформі?
            </button>
          </h2>
          <div id="a7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q7">
            <div class="accordion-body text-muted">
              <p>Зареєструйтесь як майстер, заповніть профіль, додайте портфоліо та пройдіть верифікацію. Після модерації ваш профіль стане доступним клієнтам.</p>
              <p class="mb-0">Рекомендуємо додати якісні фото робіт і детальний опис послуг — це підвищує рейтинг і довіру користувачів.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q8">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a8" aria-expanded="false" aria-controls="a8">
              Чи можна замовити ремонт або переробку одягу?
            </button>
          </h2>
          <div id="a8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q8">
            <div class="accordion-body text-muted">
              <p>Так, у каталозі майстрів оберіть категорію «Ремонт/перешив». Опишіть задачу (укорочення, заміна фурнітури, посадка по фігурі) та додайте фото для оцінки обсягу робіт.</p>
              <p class="mb-0">Майстер запропонує варіанти і вартість після діагностики виробу.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q9">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a9" aria-expanded="false" aria-controls="a9">
              Які гарантії надає платформа?
            </button>
          </h2>
          <div id="a9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q9">
            <div class="accordion-body text-muted">
              <p>Ми забезпечуємо захист платежів, модерацію профілів, систему відгуків і підтримку спорів. У разі порушення умов замовлення діє політика повернення коштів.</p>
              <p class="mb-0">Всі ключові кроки (терміни, зміни ТЗ, підтвердження примірок) фіксуються в системі для прозорості процесу.</p>
            </div>
          </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm">
          <h2 class="accordion-header" id="q10">
            <button class="accordion-button collapsed fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#a10" aria-expanded="false" aria-controls="a10">
              Чи можна замовити дитячий одяг?
            </button>
          </h2>
          <div id="a10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion" aria-labelledby="q10">
            <div class="accordion-body text-muted">
              <p>Так. Оберіть майстрів зі спеціалізацією «Дитячий одяг». Вони враховують анатомічні особливості, комфорт і безпечні матеріали.</p>
              <p class="mb-0">За потреби майстер підкаже оптимальні тканини, фурнітуру та фасони для активних дітей.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Блок підтримки -->
      <div class="support-block bg-light p-4 rounded text-center mt-5">
        <h3 class="h5 mb-2">Не знайшли відповідь?</h3>
        <p class="text-muted mb-3">Наша служба підтримки готова допомогти вам у будь-який час</p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
          <a href="mailto:support@dresscode.com" class="btn btn-primary px-4">
            Написати в підтримку
          </a>
          <a href="tel:+380441234567" class="btn btn-outline-secondary px-4">
            Подзвонити
          </a>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
.accordion-button:not(.collapsed) {
  background-color: #f8f9fa;
  color: #4a6fa5;
  box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
}

.accordion-button:focus {
  box-shadow: 0 0 0 0.25rem rgba(74, 111, 165, 0.25);
  border-color: #4a6fa5;
}

.accordion-body {
  line-height: 1.6;
}
</style>
@endsection