<?php


namespace App\Security;


use App\Entity\FreezerItem;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class FreezerItemVoter extends Voter
{
    const REMOVE = 'remove';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if ($attribute !== self::REMOVE) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof FreezerItem) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var FreezerItem $item */
        $item = $subject;

        if ($attribute !== self::REMOVE) {
            throw new \LogicException('Unauthorized attribute: ' . $attribute);
        }

        return $this->canRemove($item, $user);
    }

    private function canRemove(FreezerItem $item, User $user)
    {
        // cannot remove an item that is not persisted yet
        if (is_null($item->getId())) {
            return false;
        }

        $userFreezers = $user->getHouse()->getFreezers();

        if ($userFreezers->contains($item->getFreezer())) {
            return true;
        }

        return false;
    }
}
