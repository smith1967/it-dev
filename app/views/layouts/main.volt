<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">IT-Dev</a>
        </div>
        {{ elements.getMenu() }}
    </div>
</div>

<div class="container">
    {{ content() }}
    <hr>
    <footer>
        <p>&copy; IT-Development Club</p>
    </footer>
</div>
