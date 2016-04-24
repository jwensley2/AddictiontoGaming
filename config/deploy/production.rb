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

set :branch, 'master'
set :deploy_to, "/home/atg/addictiontogaming.com"
set :linked_files, %w{.env}
set :linked_dirs, %w{public/games public/motd storage/logs}

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
	desc "Run Migrations"
	task :laravel_migrate do
		on roles(:web) do
			within release_path do
				execute :php, "artisan migrate"
			end
		end
	end

	desc "Rollback Migrations"
	task :laravel_rollback do
		on roles(:web) do
			within release_path do
				execute :php, "artisan migrate:rollback"
			end
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

    desc "Set permissions"
    task :set_permissions do
        on roles(:web) do
            within release_path do
                execute "chmod", "777", "storage/framework/views"
            end
        end
    end

	after :updated, "deploy:composer_install"
	after :updated, "deploy:laravel_migrate"
	after :updated, "deploy:set_permissions"
	after :published, "restart_php"
end