<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <pre>
                <code class="language-php">
include_once("quanta/quanta.php");
include_once("modules/user-module/user-module.php");

$quanta = new Quanta();
$quanta->databaseHandler->init("127.0.0.1", "quanta_test", "root", "");

$user_module = new UserModule("user_module");
$quanta->add_module($user_module);
$quanta->load_modules();

include_once("inc/components.php");
include_once("inc/actions.php");

$quanta->routeHandler->initial_routing('page', 'fallbackComponent');
$quanta->routeHandler->register_route('news', 'grid');

$quanta->actionHandler->init();
$quanta->process_action(false);
                </code>
            </pre>
        </div>
        <div class="col-lg-6">
            <h2 class="display-5 fw-bold lh-1 mb-3">The Future of Flexible PHP Development</h2>
            <p class="lead">Quanta is a cutting-edge PHP framework built to empower developers who value flexibility,
                modularity, and innovation. Designed with a component-based architecture at its core, Quanta allows you
                to break your applications into reusable, manageable parts, making development faster, easier, and more
                efficient.</p>
            <p>Whether you're building small projects or large-scale applications, Quanta provides the tools you need
                to succeed—intuitive routing, dynamic components, and a lightweight yet powerful structure. Its modular
                approach ensures that you stay in control, scaling effortlessly while keeping your codebase clean and
                organized.</p>
            <p>
                With Quanta, you’re not just coding—you’re creating a seamless development experience tailored to modern
                demands. Build smarter, innovate faster.</p>
        </div>
    </div>
</div>