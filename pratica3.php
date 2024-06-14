// User.php
class User {
    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($id, $name, $email, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}

// UserRepository.php
class UserRepository {
    public function save(User $user) {
        // Save user to database
        DB::table('users')->insert([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ]);
    }

    public function getAllUsers() {
        // Get all users from database
        return DB::table('users')->get();
    }
}

// EmailService.php
class EmailService {
    public function sendWelcomeEmail(User $user) {
        // Send welcome email
        mail($user->email, "Welcome", "Thank you for registering!");
    }
}

// CSVExporter.php
class CSVExporter {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function exportToCSV() {
        $users = $this->userRepository->getAllUsers();
        $csv = "id,name,email\n";
        foreach ($users as $user) {
            $csv .= "{$user->id},{$user->name},{$user->email}\n";
        }
        file_put_contents('users.csv', $csv);
    }
}

// Usage
$user = new User(1, 'John Doe', 'john@example.com', 'secret');
$userRepository = new UserRepository();
$emailService = new EmailService();
$csvExporter = new CSVExporter($userRepository);

$userRepository->save($user);
$emailService->sendWelcomeEmail($user);
$csvExporter->exportToCSV();
