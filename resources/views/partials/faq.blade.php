@php
    $faqs = [
        ['What is Opusio?', 'Opusio is an online portfolio generator. You fill in your details once, choose one of three templates, and Opusio builds a portfolio page you can preview, edit, delete and share with a link.'],
        ['Do I need an account?', 'Yes, to create or edit a portfolio. You sign up with your name, email and a password, so your portfolios stay private to you. People you share a link with do not need an account to view your portfolio.'],
        ['Where is my information stored?', 'In an online PostgreSQL database hosted on Supabase. Your profile, education, skills, projects, experience and links are saved in separate, related tables, so they are still there when you come back.'],
        ['Who can see my portfolio?', 'Only you can open your Manage page, edit, change the template, download the PDF or delete a portfolio. Anyone you give the public link to can view the finished portfolio, but they can never change it.'],
        ['Can I change my template later?', 'Yes, at any time. Open Manage, choose Template, and pick another design. Your information stays the same; only the look changes.'],
        ['Can I edit or delete my portfolio?', 'Yes. Edit lets you change any detail. Delete removes the portfolio and everything attached to it permanently, after a confirmation step.'],
        ['What kind of profile photo can I use?', 'JPG, PNG or WEBP up to 5 MB. Opusio shrinks the saved copy to a maximum of 900 pixels so your portfolio loads quickly. You can remove or replace the photo at any time.'],
        ['Can I add my certificates?', 'Yes. In the form, the Certificates section lets you pick several photos at once, up to 10 per portfolio (JPG, PNG or WEBP, 5 MB each). You can remove any photo before saving, and visitors can tap a certificate on your portfolio to see it full size. Certificates are also included in the PDF.'],
        ['Does it work on phones and tablets?', 'Yes. Every page and every template adapts to phone, tablet and desktop screens, and buttons are sized for touch.'],
        ['Can I print my portfolio as a résumé?', 'Yes. The Formal template is designed for print: open its full page and use your browser\'s Print command (Ctrl+P or Cmd+P).'],
        ['Is there a dark mode?', 'Yes. The Opusio app and each portfolio template have their own light and dark mode buttons. They start from your device setting and remember your choice separately.'],
        ['What is the colour animation in the Aesthetic template?', 'The accent colours slowly cycle through the spectrum. A pause button sits at the top of the page, and the animation stays off automatically if your device is set to reduce motion.'],
    ];
    $items = isset($limit) ? array_slice($faqs, 0, $limit) : $faqs;
@endphp
<div class="faq">
    @foreach ($items as [$q, $a])
        <details><summary>{{ $q }}</summary><p>{{ $a }}</p></details>
    @endforeach
</div>
