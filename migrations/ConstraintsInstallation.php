<?php


class ConstraintsInstallation extends Connexion
{
    public function addConstraints()
    {
        $bdd = $this->dbConnect();

        $statement = $bdd->prepare('ALTER TABLE `comments`
                                                ADD CONSTRAINT `lien_comment_author` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
                                                ADD CONSTRAINT `lien_post_comment` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `favorites_posts`
                                                ADD CONSTRAINT `lien_favorites_posts_author` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `posts`
                                                ADD CONSTRAINT `lien_author_posts` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON UPDATE CASCADE');
        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `posts` 
                                                ADD CONSTRAINT `lien_categories_posts` FOREIGN KEY (`id_category`) REFERENCES `categories`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE');

        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `tokens`
                                                ADD CONSTRAINT `lien_user_token` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
        $statement->execute();
    }
}