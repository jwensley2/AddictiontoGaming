set :branch, 'master'

# Simple Role Syntax
# ==================
# Supports bulk-adding hosts to roles, the primary
# server in each group is considered to be the first
# unless any hosts have the primary property set.
# Don't declare `role :all`, it's a meta role
role :web, %w{atg@addictiontogaming.com}

# Extended Server Syntax
# ======================
# This can be used to drop a more detailed server
# definition into the server list. The second argument
# something that quacks like a hash can be used to set
# extended properties on the server.
# server 'addictiontogaming.com', user: 'atg', roles: %w{web app}, my_property: :my_value

# you can set custom ssh options
# it's possible to pass any option but you need to keep in mind that net/ssh understand limited list of options
# you can see them in [net/ssh documentation](http://net-ssh.github.io/net-ssh/classes/Net/SSH.html#method-c-start)
# set it globally
#  set :ssh_options, {
#    keys: %w(/home/rlisowski/.ssh/id_rsa),
#    forward_agent: false,
#    auth_methods: %w(password)
#  }
# and/or per server
# server 'example.com',
#   user: 'user_name',
#   roles: %w{web app},
#   ssh_options: {
#     user: 'user_name', # overrides user setting above
#     keys: %w(/home/user_name/.ssh/id_rsa),
#     forward_agent: false,
#     auth_methods: %w(publickey password)
#     # password: 'please use keys'
#   }
# setting per server overrides global ssh_options

set :deploy_to, "/home/atg/addictiontogaming.com"
set :release_path, fetch(:latest_release_directory)
set :linked_dirs, %w{public/games public/motd}
set :linked_files, %w{.env.production.php}

desc "Check that we can access everything"
task :check_write_permissions do
	on roles(:all) do |host|
		if test("[ -w #{fetch(:deploy_to)} ]")
			info "#{fetch(:deploy_to)} is writable on #{host}"
		else
			error "#{fetch(:deploy_to)} is not writable on #{host}"
		end
	end
end


# Laravel deployment
namespace :deploy do
	desc "Set the proper permissions on the release path"
	task :finalize_update do
		on roles(:web) do
			execute "chmod -R g+w #{releases_path}/#{release_name}"
		end
	end

	desc "Symlink to the new release path"
	task :symlink do
		on roles(:web) do
			# Symlink the deploy
			execute "rm -f #{current_path}"
			execute "ln -nfs #{release_path} #{current_path}"
		end
	end

	desc "Create a LARAVEL_ENV file"
	task :set_environment do
		on roles(:web) do
			execute "cd #{release_path} && touch LARAVEL_ENV && echo -n 'production' > LARAVEL_ENV"
		end
	end

	desc "Symlink shared path"
	task :link_shared do
		on roles(:web) do
			# run "ln -nfs #{shared_path}/system #{current_release}/public/system"
		end
	end

	desc "Run Migrations"
	task :laravel_migrate do
		on roles(:web) do
			execute "php  #{release_path}/artisan migrate --env=production"
		end
	end

	desc "Rollback Migrations"
	task :laravel_rollback do
		on roles(:web) do
			execute "php  #{release_path}/artisan migrate:rollback --env=production"
		end
	end

	task :fix_storage_permissions do
		on roles(:web) do
			# Set permissions and clean directories
			execute "cd #{release_path}/app/storage; if [ -d cache ]; then chmod -R 777 cache; rm -f cache/*; fi"
			execute "cd #{release_path}/app/storage; if [ -d purifier_cache ]; then chmod -R 777 purifier_cache; rm -f purifier_cache/*; fi"
			execute "cd #{release_path}/app/storage; if [ -d views ]; then chmod -R 777 views; rm -f views/*; fi"

			# Set permissions
			execute "cd #{release_path}/app/storage; if [ -d database ]; then chmod -R 777 database; fi"
			execute "cd #{release_path}/app/storage; if [ -d logs ]; then chmod -R 777 logs; fi"
			execute "cd #{release_path}/app/storage; if [ -d meta ]; then chmod -R 777 meta; fi"
			execute "cd #{release_path}/app/storage; if [ -d sessions ]; then chmod -R 777 sessions; fi"
			execute "cd #{release_path}/app/storage; if [ -d work ]; then chmod -R 777 work; fi"
		end
	end

	desc "Run composer install"
	task :composer_install do
		on roles(:web) do
			within release_path do
				execute "composer", "install", "--no-dev", "--optimize-autoloader"
			end
		end
	end

	# This task lets you keep server-specific configuration files in "shared/config/".
	# Any file there will just be copied to your app/config directory.
	task :copy_config do
		on roles(:web) do
			# run "cp #{shared_path}/config/* #{current_release}/app/config/"
		end
	end

	after :updated, "deploy:set_environment"
	after :updated, "deploy:composer_install"
	after :updated, "deploy:fix_storage_permissions"
	after :updated, "deploy:laravel_migrate"
	after :updated, "deploy:symlink"
end