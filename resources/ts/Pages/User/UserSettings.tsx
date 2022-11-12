import Button from "@/Components/Button";
import UserSettingsCard from "@/Components/UserSettings/UserSettingsCard";
import Authenticated from "@/Layout/User/Authenticated";
import { User } from "@/Types/User";
import { useState } from "react";

type Props = {
  user: User;
};

export default function UserSettings(props: Props) {
  const [enableTwoFA, setEnableTweFA] = useState(false);

  const handleClickSubmit = () => setEnableTweFA(true);
  return (
    <Authenticated>
      <div className="w-3/5">
        <UserSettingsCard title="メールアドレス">
          <div>{props.user.email}</div>
        </UserSettingsCard>
        <UserSettingsCard title="二要素認証">
          {enableTwoFA ? (
            <div className="flex">
              <div className="mr-3">
                <Button>メールアドレス</Button>
              </div>
              <div className="mr-3">
                <Button>認証アプリ</Button>
              </div>
            </div>
          ) : (
            <Button onClick={handleClickSubmit}>有効化</Button>
          )}
        </UserSettingsCard>
      </div>
    </Authenticated>
  );
}
