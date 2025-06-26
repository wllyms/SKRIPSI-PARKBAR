public function run(): void
{
$this->call([
JabatanSeeder::class,
SubJabatanSeeder::class,
PegawaiSubJabatanSeeder::class,
KategoriSeeder::class,
StaffSeeder::class,
UserSeeder::class,
]);
}