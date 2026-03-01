<?php

$role = $_GET['role'] ?? 'Пользователь';
$name = $_GET['name'] ?? 'Гость';

$skillsString = $_GET['skills'] ?? '';


$skills = [];
if (!empty($skillsString)) { $rawSkills = explode(',', $skillsString);
    foreach ($rawSkills as $skill) {
        $cleanedSkill = trim($skill);
        if (!empty($cleanedSkill)) {$skills[] = $cleanedSkill;}
    }
}
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$profile = [
    'name' => $name,
    'role' => $role,
    'skills' => $skills
];

echo "<!DOCTYPE html>";
echo "<html lang='ru'>";
echo "<head>";
echo "<title>Профиль пользователя</title>";
echo "<meta charset='UTF-8'>";
echo "</head>";
echo "<body>";

echo "<p>Роль: " . e($profile['role']) . "</p>";

echo "<h1>Профиль: " . e($profile['name']) . "</h1>";

echo "<h3>Навыки:</h3>";

if (!empty($profile['skills'])) {
    echo "<ul>";
    foreach ($profile['skills'] as $skill) {
        echo "<li>" . e($skill) . "</li>";
    }
    echo "</ul>";
} else {echo "<p>ничего нет</p>";}

echo "</body>";
echo "</html>";
?>