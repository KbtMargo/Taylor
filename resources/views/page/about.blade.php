{{-- @extends('layouts.app') --}}

@section('title', 'Про нас | DressCode')

@section('content')
  <section class="about-section">
    <h1>Про DressCode</h1>
    <p>
      Ми створили платформу, де кожен може знайти свого ідеального майстра та
      втілити найсміливіші модні ідеї в життя.
    </p>
  </section>

<section class="split about-hero card">
    <div>
      <h2>Наша історія</h2>
      <p>
        DressCode народилася з простої ідеї: кожна людина заслуговує на одяг, який
        ідеально підходить саме їй. У світі масового виробництва ми побачили потребу
        в платформі, яка б поєднала талановитих майстрів з клієнтами, які цінують
        якість та індивідуальність.
      </p>
      <p>
        Наша команда складається з професіоналів у сфері моди, технологій та ремісництва.
        Ми детально вивчили потреби як клієнтів, так і майстрів, щоб створити платформу,
        яка була б зручною та ефективною для всіх учасників.
      </p>
      <p>
        Сьогодні DressCode — це спільнота професіоналів та поціновувачів унікального одягу,
        де кожне замовлення стає новою історією успіху.
      </p>
    </div>

    <div class="media">
      <img
        src="https://images.unsplash.com/photo-1753164597544-a2736833357e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
        alt="Ательє DressCode">
    </div>
  </section>

  <section class="about-center">
    <h2>Наші принципи</h2>
    <p class="muted">Цінності, які ведуть нас вперед</p>

    <div class="cards-3">
      <article class="card elevated">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target h-8 w-8 text-blue-600" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg></div>
        <h3>Наша місія</h3>
        <p>
З'єднувати клієнтів з талановитими майстрами для створення унікального одягу, який підкреслює індивідуальність кожної людини.

        </p>
      </article>

      <article class="card elevated">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart h-8 w-8 text-blue-600" aria-hidden="true"><path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"></path></svg></div>
        <h3>Наші цінності</h3>
        <p>
Якість, індивідуальність, професіоналізм та повага до ремісництва. Ми віримо, що кожна людина заслуговує на одяг, створений спеціально для неї.

        </p>
      </article>

      <article class="card elevated">
<div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award h-8 w-8 text-blue-600" aria-hidden="true"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle></svg></div>        <h3>Наша експертиза</h3>
          <h3>Наша експертиза</h3>       
<p>
          Команда DressCode має багаторічний досвід у сфері моди та технологій. Ми знаємо, як поєднати традиційне ремісництво з сучасними інноваціями.
        </p>
      </article>
    </div>
  </section>

  <section class="stats-strip">
    <div class="stats-strip__inner">
      <h2>DressCode в цифрах</h2>
      <p class="muted inv">Результати, якими ми пишаємося</p>

      <div class="stats-4">
        <div>
          <strong>500+</strong>
          <span>Перевірених майстрів</span>
        </div>
        <div>
          <strong>2000+</strong>
          <span>Виконаних замовлень</span>
        </div>
        <div>
          <strong>150+</strong>
          <span>Видів матеріалів</span>
        </div>
        <div>
          <strong>98%</strong>
          <span>Задоволених клієнтів</span>
        </div>
      </div>
    </div>
  </section>

  <section class="split card">
    <div class="media">
      <img
        src="https://images.unsplash.com/photo-1638432249748-829a35c334cf?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
        alt="Костюм на замовлення">
    </div>

    <div>
      <h2>Наші досягнення</h2>
        <ul class="checklist">
        <li>
            <span class="icon-check">✔</span>
            <span>Перша українська платформа для індивідуального пошиву</span>
        </li>
        <li>
            <span class="icon-check">✔</span>
            <span>Власна система перевірки майстрів</span>
        </li>
        <li>
            <span class="icon-check">✔</span>
            <span>Безпечні платежі та гарантії якості</span>
        </li>
        <li>
            <span class="icon-check">✔</span>
            <span>Підтримка місцевих ремісників та майстрів</span>
        </li>
        <li>
            <span class="icon-check">✔</span>
            <span>Еко-френдлі підхід до виробництва одягу</span>
        </li>
        </ul>

      <aside class="note">
        <h4>Наша відповідальність</h4>
        <p>
          Ми не просто з’єднуємо людей — ми створюємо спільноту, де кожен відчуває підтримку
          та має можливість розвиватися. Платформа сприяє розвитку малого бізнесу та
          збереженню традицій ремісництва.
        </p>
      </aside>
    </div>
  </section>

  <section class="contact-hero">
    <h2>Зв'яжіться з нами</h2>
    <p>Ми готові допомогти вам з будь-якими питаннями про DressCode</p>
  </section>

  <div class="contact-grid">
    <aside class="contact-aside card">
      <ul class="contact-list">
        <li>
          <span class="i">📧</span>
          <div>
            <h3>Email</h3>
            <a href="mailto:info@dresscode.com">info@dresscode.com</a><br>
            <a href="mailto:support@dresscode.com">support@dresscode.com</a>
            <p class="muted">Напишіть нам для загальних питань або технічної підтримки</p>
          </div>
        </li>

        <li>
          <span class="i">📞</span>
          <div>
            <h3>Телефон</h3>
            <a href="tel:+380441234567">+380 (44) 123-45-67</a><br>
            <a href="tel:+380509876543">+380 (50) 987-65-43</a>
            <p class="muted">Зателефонуйте нам у робочий час для швидкої консультації</p>
          </div>
        </li>

        <li>
          <span class="i">📍</span>
          <div>
            <h3>Адреса</h3>
            <p>вул. Хрещатик, 10<br>Київ, 01001, Україна</p>
            <p class="muted">Завітайте до нашого офісу для особистої консультації</p>
          </div>
        </li>

        <li>
          <span class="i">⏰</span>
          <div>
            <h3>Режим роботи</h3>
            <p>Пн–Пт: 9:00–18:00<br>Сб: 10:00–16:00<br>Нд: Вихідний</p>
            <p class="muted">Ми готові допомогти вам у зазначений час</p>
          </div>
        </li>
      </ul>
      <div class="social">
        <h4>Слідкуйте за нами</h4>
        <div class="social-row">
          <a href="#" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook h-5 w-5" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
          <a href="#" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram h-5 w-5" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg></a>
          <a href="#" aria-label="Twitter"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-twitter h-5 w-5" aria-hidden="true"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg></a>
        </div>
        <p class="muted">Останні новини, поради від майстрів та натхнення для вашого стилю</p>
      </div>
    </aside>

    <section class="contact-form card">
      <h3>Надішліть повідомлення</h3>
      <p class="muted">Заповніть форму — ми зв’яжемося з вами протягом 24 годин</p>

      <form method="post" action="#">
        @csrf
        <div class="grid2">
          <label>
            Ваше ім’я
            <input name="name" placeholder="Введіть ваше ім’я">
          </label>

          <label>
            Email
            <input type="email" name="email" placeholder="example@email.com">
          </label>

          <label>
            Телефон (необов’язково)
            <input name="phone" placeholder="+380 (XX) XXX-XX-XX">
          </label>

          <label>
            Тема звернення
            <select name="topic">
              <option selected disabled>Оберіть тему</option>
              <option>Замовлення</option>
              <option>Питання по сервісу</option>
              <option>Співпраця</option>
            </select>
          </label>
        </div>

        <label class="mt-2">
          Повідомлення
          <textarea name="message" rows="4" placeholder="Детально опишіть ваше питання або пропозицію..."></textarea>
        </label>

        <button type="submit" class="button w-100 mt-2">✈️ Відправити повідомлення</button>
      </form>

      <div class="help card soft mt-2">
        <div class="row">
          <span class="i">💬</span>
          <div>
            <h3>Потрібна швидка допомога?</h3>
            <p class="muted">
              Скористайтеся онлайн-чатом на нашому сайті або зателефонуйте за номером гарячої лінії
              для негайної консультації.
            </p>
            <div class="actions">
              <a href="#" class="button ghost">Онлайн-чат</a>
              <a href="tel:+380800000000" class="button secondary">Гаряча лінія</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
