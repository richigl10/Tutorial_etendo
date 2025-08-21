<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FromExistingDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Iniciando migración de datos desde erp_tutorial...');

        // 1. Migrar módulos
        $this->migrateModules();

        // 2. Migrar videos
        $this->migrateVideos();

        // 3. Migrar usuarios
        $this->migrateUsers();

        // 4. Migrar cualquier otra tabla
        $this->migrateOtherTables();

        $this->command->info('¡Migración de datos completada!');
    }

    protected function migrateModules()
    {
        if (!DB::connection('erp_tutorial')->getSchemaBuilder()->hasTable('modules')) {
            $this->command->warn('La tabla modules no existe en la BD origen');
            return;
        }

        $count = DB::connection('erp_tutorial')->table('modules')->count();
        $this->command->info("Migrando {$count} módulos...");

        $progressBar = $this->command->getOutput()->createProgressBar($count);

        DB::connection('erp_tutorial')->table('modules')->orderBy('id')->chunk(100, function ($modules) use ($progressBar) {
            foreach ($modules as $module) {
                \App\Models\Module::updateOrCreate(
                    ['id' => $module->id],
                    [
                        'name' => $module->name,
                        'description' => $module->description,
                        'order' => $module->order ?? 0,
                        'created_at' => $module->created_at,
                        'updated_at' => $module->updated_at,
                        // Agrega aquí cualquier otro campo
                    ]
                );
                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->command->newLine();
    }

    protected function migrateVideos()
    {
        if (!DB::connection('erp_tutorial')->getSchemaBuilder()->hasTable('videos')) {
            $this->command->warn('La tabla videos no existe en la BD origen');
            return;
        }

        $count = DB::connection('erp_tutorial')->table('videos')->count();
        $this->command->info("Migrando {$count} videos...");

        $progressBar = $this->command->getOutput()->createProgressBar($count);

        DB::connection('erp_tutorial')->table('videos')->orderBy('id')->chunk(100, function ($videos) use ($progressBar) {
            foreach ($videos as $video) {
                \App\Models\Video::updateOrCreate(
                    ['id' => $video->id],
                    [
                        'module_id' => $video->module_id,
                        'title' => $video->title,
                        'description' => $video->description,
                        'path' => $video->path,
                        'pdf_path' => $video->pdf_path,
                        'duration' => $video->duration ?? 0,
                        'completed' => $video->completed ?? false,
                        'created_at' => $video->created_at,
                        'updated_at' => $video->updated_at,
                    ]
                );
                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->command->newLine();
    }

    protected function migrateUsers()
    {
        if (!DB::connection('erp_tutorial')->getSchemaBuilder()->hasTable('users')) {
            $this->command->warn('La tabla users no existe en la BD origen');
            return;
        }

        $count = DB::connection('erp_tutorial')->table('users')->count();
        $this->command->info("Migrando {$count} usuarios...");

        $progressBar = $this->command->getOutput()->createProgressBar($count);

        DB::connection('erp_tutorial')->table('users')->orderBy('id')->chunk(100, function ($users) use ($progressBar) {
            foreach ($users as $user) {
                \App\Models\User::updateOrCreate(
                    ['id' => $user->id],
                    [
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified_at' => $user->email_verified_at,
                        'password' => $user->password, // Considera rehashear si es necesario
                        'remember_token' => $user->remember_token,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ]
                );
                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->command->newLine();
    }

    protected function migrateOtherTables()
    {
        // Ejemplo para migrar otras tablas
        $tables = DB::connection('erp_tutorial')->getSchemaBuilder()->getAllTables();

        foreach ($tables as $table) {
            $tableName = reset((array)$table);

            // Saltar tablas ya migradas
            if (in_array($tableName, ['modules', 'videos', 'users', 'migrations', 'password_reset_tokens', 'failed_jobs', 'personal_access_tokens'])) {
                continue;
            }

            $this->command->info("Migrando tabla {$tableName}...");

            $count = DB::connection('erp_tutorial')->table($tableName)->count();
            $progressBar = $this->command->getOutput()->createProgressBar($count);

            $modelClass = $this->getModelClass($tableName);

            DB::connection('erp_tutorial')->table($tableName)->orderBy('id')->chunk(100, function ($records) use ($progressBar, $tableName, $modelClass) {
                foreach ($records as $record) {
                    if (class_exists($modelClass)) {
                        $modelClass::updateOrCreate(
                            ['id' => $record->id],
                            (array)$record
                        );
                    } else {
                        DB::table($tableName)->updateOrInsert(
                            ['id' => $record->id],
                            (array)$record
                        );
                    }
                    $progressBar->advance();
                }
            });

            $progressBar->finish();
            $this->command->newLine();
        }
    }

    protected function getModelClass($tableName)
    {
        // Convierte nombres de tabla a nombres de modelo (ej: user_roles -> UserRole)
        $studly = str_replace(' ', '', ucwords(str_replace('_', ' ', $tableName)));
        return '\\App\\Models\\'.$studly;
    }
}
