<table>
	<thead>
		<tr>
			<th>Sl No</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Contact number</th>
			<th>Country</th>
			<?php /* <th>Type</th> */ ?>
			<th>Organization Name</th>
			<th>Program Interested</th>
			<?php /* <th>Subject</th> */ ?>
			<th>Comment</th>
			<th>Request Date</th>
			
		</tr>
	</thead>
	<tbody>
	    @if( !empty($contact) && $contact->count() >0 )
			<?php $inc = 1; ?>
			@foreach($contact as $item)
					<tr>
						<th >{{ $inc++ }}</th>
                        <td>{{$item->getName()}}</td>
                        <td>{{$item->getEmail()}}</td>
                        <td>{{$item->getPhoneNumber()}}</td>
                        <td>{{$item->getCountryName()}}</td>
                       <?php /* <td>{{$item->getTypeTitle()}}</td> */ ?>
                        <td>{{$item->getOrganizationName()}}</td>
                        <td>{{$item->getProgramTitle()}}</td>
                       <?php /* <td>{{$item->getSubject()}}</td> */ ?>
                        <td>{{$item->getMessage()}}</td>
                        <td>{{$item->submittedAt()}}</td>				
					</tr>
			@endforeach
	    @endif
	</tbody>
</table>
