<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">

    <div class="container-fluid">

        <div>

            <h4 class="mb-0 fw-bold">
                @yield('page-title','Tableau de bord')
            </h4>

            <small class="text-muted">
                Bienvenue dans votre espace de gestion.
            </small>

        </div>

        <div class="ms-auto d-flex align-items-center">

            <div class="text-end me-3">

                <div class="fw-semibold">

                    {{ session('utilisateur')->nom }}

                </div>

                <small class="text-muted">

                    {{ ucfirst(session('utilisateur')->role) }}

                </small>

            </div>

            <div class="dropdown">

                <button
                    class="btn btn-light border dropdown-toggle"
                    data-bs-toggle="dropdown">

                    Mon compte

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>

                        <span class="dropdown-item-text">

                            <strong>{{ session('utilisateur')->email }}</strong>

                        </span>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <a
                            class="dropdown-item"
                            href="{{ route('logout') }}">

                            Déconnexion

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>