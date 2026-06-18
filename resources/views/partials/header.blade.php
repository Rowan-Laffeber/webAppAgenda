<nav class="flex items-center border-b border-slate-200 bg-white text-xs font-bold uppercase tracking-widest text-slate-400 select-none">

  <div class="flex h-16 w-16 items-center justify-center border-r border-slate-200 bg-gradient-to-br from-indigo-950 via-indigo-900 to-slate-900">
    <img src="https://placehold.co" alt="Logo" class="h-6 w-6 opacity-80 object-contain">
  </div>

  <div class="flex h-16">
    <a href="/agendas" class="flex items-center border-r border-slate-200 px-8 text-slate-500 transition duration-200 hover:bg-slate-50 hover:text-slate-900">
      Agenda
    </a>

    <a href="/friends?tab=friends" class="flex items-center border-r border-slate-200 px-8 text-slate-500 transition duration-200 hover:bg-slate-50 hover:text-slate-900">
      Friends
    </a>

    <a href="/profile" class="flex items-center border-r border-slate-200 px-8 text-slate-500 transition duration-200 hover:bg-slate-50 hover:text-slate-900">
      Profile
    </a>
  </div>

  <div class="flex-1 h-16"></div>

  <div class="flex h-16 items-center justify-center border-l border-slate-200 px-6">
    <form method="POST" action="/logout">
      @csrf
      <button type="submit" class="text-slate-400 hover:text-rose-600 transition duration-200 uppercase font-bold tracking-widest text-xs">
        Logout
      </button>
    </form>
  </div>

</nav>
