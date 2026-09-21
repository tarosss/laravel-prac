database.phpにtelescope用のデータベース接続を作成する

環境変数にTELESCOPE_DB_CONNECTIONを設定する

telescope.phpのstorage内の環境変数を先ほどのものに修正

docker compose exec app php artisan migrate --database=telescope_sqlite --path=database/telescope/migrations
を実行してsqliteファイルを作成する