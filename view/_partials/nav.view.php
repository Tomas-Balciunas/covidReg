<header>
    <div class="header">
        <a href="/visma">Home</a>
        <a href="/visma/list">List of Appointments</a>
        <form method="POST" action="/visma/search" class="search">
            <input type="date" name="search" class="field">
            <input type="submit" name="execute" value="Search">
        </form>
        <a href="/visma/data">Import/Export</a>
    </div>
</header>

<style>
    .header {
        display: flex;
        justify-content: center;
        margin-bottom: 3em;
    }

    .header>a {
        margin-right: 2em;
    }

    .search {
        display: flex;
        flex-flow: row;
        width: 13em;
    }

    .field {
        margin-right: 1em;
        width: 9em;
    }
</style>