/*
* Curso de Engenharia de Software - UniEVANGÉLICA 
* Disciplina de Programação Web 
* Dev: Sebastian Fabian Pires do Carmo 2120283
* DATA 14/06/2024
*/ 

// User.php
class User {
    public $id;
    public $nome;
    public $email;
    public $pass;

    public function __construct($id, $nome, $email, $pass) {
        $this->id = $id;
        $this->name = $nome;
        $this->email = $email;
        $this->password = $pass;
    }
}

// UserRepository.php
class UserRepository {
    public function save(User $user) {
        // Save user to database
        DB::table('users')->insert([
            'id' => $user->id,
            'nome' => $user->nome,
            'email' => $user->email,
            'pass' => $user->pass
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
        mail($user->email, "Obrigado por Registrar");
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
            $csv .= "{$user->id},{$user->nome},{$user->email}\n";
        }
        file_put_contents('users.csv', $csv);
    }
}

// Usage
$user = new User(1, 'teste', 'teste@example.com', 'senha123');
$userRepository = new UserRepository();
$emailService = new EmailService();
$csvExporter = new CSVExporter($userRepository);

$userRepository->save($user);
$emailService->sendWelcomeEmail($user);
$csvExporter->exportToCSV();
