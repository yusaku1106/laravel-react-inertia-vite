import { ReactNode } from "react";

type Props = {
    title: string;
    children: ReactNode;
};

export default function UserSettingsCard(props: Props) {
    return (
        <div className="flex py-10 border-t-2">
            <div className="font-bold w-52">{props.title}</div>
            <div>{props.children}</div>
        </div>
    );
}
