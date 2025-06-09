import {emptyRecipient} from '../Services/empty-objects';
import useCrud from '../Hooks/useCrud';
import {useCallback, useState} from 'react';
import ComponentsContainer from '../Components/Containers/ComponentsContainer';
import SectionTitle from '../Components/Titles/SectionTitle';
import PrimaryButton from '../Components/Buttons/PrimaryButton';
import Icons from '../Components/Icons/Icons';
import FullTable from '../Components/Table/FullTable';
import HeaderRow from '../Components/Table/HeaderRow';
import DataRow from '../Components/Table/DataRow';
import TableData from '../Components/Table/TableData';
import IconButton from '../Components/Buttons/IconButton';
import RecipientModal from '../Components/Modals/RecipientModal';

const RecipientsView = ({sensor, recipients}: {sensor: Sensor, recipients: Recipient[]}) => {
    const [modalOpen, setModalOpen] = useState(false);
    const [activeRecipient, setActiveRecipient] = useState<Recipient>({ ...emptyRecipient, sensor: sensor });
    const {deleteMutation} = useCrud<Recipient>('/recipient');

    const handleDelete = useCallback((id: number) => {
        deleteMutation.mutate(id, 'Ali res želite izbrisati prejemnika?');
    }, [deleteMutation]);

    const handleOpenModal = useCallback((recipient: Recipient) => {
        setActiveRecipient(recipient);
        setModalOpen(true);
    }, [{ ...emptyRecipient, sensor: sensor }]);

    return <ComponentsContainer>
        <RecipientModal
            modalIsOpen={modalOpen}
            closeModal={() => setModalOpen(false)}
            existingRecipient={activeRecipient}
        />
        <div className="flex flex-col w-full space-y-4">
            <div className="flex flex-row justify-between items-center">
                <SectionTitle label={"Prejemniki opozoril"}/>
                <PrimaryButton props={{
                    label: 'Dodaj',
                    color: 'bg-teal-500 text-black-100',
                    activeColor: 'hover:bg-teal-400',
                    direction: 'row',
                    icon: <Icons.Add size={'1x'}/>,
                    onClick: () => handleOpenModal({ ...emptyRecipient, sensor: sensor }),
                    type: 'button'
                }}/>
            </div>
            <FullTable>
                <HeaderRow columns={['E-mail', 'Akcije']}/>
                <tbody>
                {recipients.map((recipient: Recipient) => {
                    return <DataRow key={recipient.id}>
                        <TableData>{recipient.email}</TableData>
                        <TableData>
                            <IconButton props={{
                                onClick: () => handleOpenModal(recipient),
                                icon: <Icons.Edit size={'1x'} />,
                                title: 'Uredi prejemnika',
                                color: 'text-blue-400',
                                activeColor: 'hover:text-blue-300 hover:scale-110',
                                direction: 'row',
                                type: 'button'
                            }}
                            />
                            <IconButton props={{
                                onClick: () => handleDelete(recipient.id),
                                icon: <Icons.Delete size={'1x'}/>,
                                title: 'Izbriši prejemnika',
                                color: 'text-red-400',
                                activeColor: 'hover:text-red-300 hover:scale-110',
                                direction: 'row',
                                type: 'button'
                            }}
                            />
                        </TableData>
                    </DataRow>
                })}
                </tbody>
            </FullTable>
        </div>
    </ComponentsContainer>
};

export default RecipientsView;