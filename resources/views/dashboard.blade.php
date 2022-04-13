@component('layout.content', ['title' => 'admin panel'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">داشبورد</li>
    @endslot

    <h2>Admin panel is here</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus animi autem beatae consequatur dolores ducimus est, in laboriosam magnam nobis pariatur placeat ratione reprehenderit saepe sit ullam veritatis vero vitae.</p>
@endcomponent
