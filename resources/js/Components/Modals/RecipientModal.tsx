import {FormEvent, useCallback, useEffect, useState} from 'react';
import Modal from 'react-modal';
import useCrud from '../../Hooks/useCrud';
import {fullModalStyle} from '../../Services/modal-styles';
import SectionTitleRow from '../Titles/SectionTitleRow';
import PrimaryButton from '../Buttons/PrimaryButton';
import Icons from '../Icons/Icons';
import StringInputField from '../Form/StringInputField';

const RecipientModal = ({ modalIsOpen, closeModal, existingRecipient }: {modalIsOpen: boolean, closeModal: () => void, existingRecipient: Recipient}) => {
    const [recipient, setRecipient] = useState<Recipient>(existingRecipient);
    const {storeMutation, updateMutation} = useCrud<Recipient>('/recipient');

    useEffect((): void => {
        setRecipient(existingRecipient);
    }, [existingRecipient, modalIsOpen]);

    const emailHandler = useCallback((value: string ): void => {
        setRecipient(prevState => ({
            ...prevState, email: value
        }));
    }, [setRecipient]);

    const saveRecipient = useCallback((e: FormEvent): void => {
        e.preventDefault();

        if (recipient.id === -1) {
            storeMutation.mutate(recipient);
        } else {
            updateMutation.mutate(recipient.id, recipient);
        }

        closeModal();
    }, [storeMutation, updateMutation, recipient]);

    return <Modal
        isOpen={modalIsOpen}
        onRequestClose={closeModal}
        ariaHideApp={false}
        style={fullModalStyle}
        contentLabel="Recipient modal">
        <SectionTitleRow titleLabel={recipient.id === -1 ? "Dodaj prejemnika" : "Uredi prejemnika"} titleSize={"text-2xl"}>
            <div className="text-red-500 hover:cursor-pointer" onClick={closeModal}>
                <Icons.Delete size={"lg"}/>
            </div>
        </SectionTitleRow>
        <div className="w-full">
            <form id="recipient-form" className="flex flex-col justify-start items-start space-y-5" onSubmit={(e: FormEvent) => saveRecipient(e)}>
                <StringInputField props={{
                    fieldName: "sensor",
                    label: "Sensor",
                    value: recipient.sensor?.name ?? '/',
                    defaultValue: '',
                    onChange: () => console.log("onChange"),
                    required: false,
                    disabled: true,
                    type: 'string',
                }} />
                <StringInputField props={{
                    fieldName: "email",
                    label: "E-mail",
                    value: recipient.email,
                    defaultValue: '',
                    onChange: (_name: string, value: string) => emailHandler(value),
                    required: true,
                    disabled: false,
                    type: 'email',
                }} />
                <div className="flex flex-row py-2 w-full justify-end items-center">
                    <PrimaryButton props={{
                        label: 'Shrani',
                        color: 'bg-teal-500 text-black-100',
                        activeColor: 'hover:bg-teal-400',
                        direction: 'row',
                        icon: <Icons.Add size={'1x'} />,
                        type: 'submit',
                    }}/>
                </div>
            </form>
        </div>
    </Modal>;
}

export default RecipientModal;