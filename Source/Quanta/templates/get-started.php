<div class="container">
    <div class="row text-center mb-4">
        <div class="col">
            <h2 class="display-5 fw-bold lh-1 mb-3">Start Building with Quanta in Minutes</h2>
            <p class="text-muted">Get up and running with Quanta quickly. Follow these simple steps to begin your
                journey.</p>
        </div>
    </div>
    <div class="row">
        <!-- Step 1: Install via Composer -->
        <div class="col-md-4 text-center">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-cloud-download fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">1. Install Quanta</h5>
                    <p class="card-text text-muted">Run the following command to install Quanta using Composer:</p>
                    <code class="d-block bg-dark text-light px-3 py-2 rounded">
                            composer create-project quanta/quanta
                        </code>
                </div>
            </div>
        </div>
        <!-- Step 2: Set Up Your First Route -->
        <div class="col-md-4 text-center">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-gear fs-1 text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold">2. Configure Your First Route</h5>
                    <p class="card-text text-muted">Easily set up your first route with Quanta’s intuitive routing
                        system:</p>
                    <code class="d-block bg-dark text-light px-3 py-2 rounded">
                            $quanta->routeHandler->register_route('home', 'homeComponent');
                        </code>
                </div>
            </div>
        </div>
        <!-- Step 3: Start the Development Server -->
        <div class="col-md-4 text-center">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="icon mb-3">
                        <i class="bi bi-play-circle fs-1 text-danger"></i>
                    </div>
                    <h5 class="card-title fw-bold">3. Start the Server</h5>
                    <p class="card-text text-muted">Launch your project locally using PHP’s built-in server:</p>
                    <code class="d-block bg-dark text-light px-3 py-2 rounded">
                            php -S localhost:8000
                        </code>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col text-center">
            <a href="https://github.com/quanta-dev" class="btn btn-primary btn-lg px-4">
                View Documentation
            </a>
        </div>
    </div>
</div>